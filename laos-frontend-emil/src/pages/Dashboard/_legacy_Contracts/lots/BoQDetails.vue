<template>
  <div class="BoQGrid" style="position:relative">
    <div style="width:1416px;">
      <div class="grid-header boq-header" style="width:100%">
        <label class="boq-label">Bill of Quantities (BoQ)</label>
        <md-button class="md-blue" style="height:22px; width:22px; margin:0.6px 5px; float:right;"
          @click.native="addNewBoQData()">
          <md-tooltip md-direction="top">New BoQ Line</md-tooltip>
          <md-icon>add</md-icon>
        </md-button>
        <span style="float:right" class="ui-icon ui-icon-search" title="Toggle search panel" @click="toggleFilterRow()">
        </span>
      </div>
      <div id="myGrid" style="width:100%;height:370px;"></div>
      <div id="pager"></div>
    </div>

    <div class="footer-container">
      <md-switch style="margin-left:4px;margin-top:7px;" v-model="autoedit" @change="toggle()">
        Auto-Edit (Off/On)
      </md-switch>

      <h2 style="margin-left:100px;margin-top:7px;border:none;">Grand Totals:</h2>
      <div class="legend">
        <md-content class="md-elevation-1" style="background-color:green;"></md-content>
        <p class="mark-title">> 100,000,000 and &#60; 500,000,000</p>
        <md-content class="md-elevation-1" style="background-color:orange;"></md-content>
        <p class="mark-title">> 500,000,000 and &#60; 1,000,000,000</p>
        <md-content class="md-elevation-1" style="background-color:red;"></md-content>
        <p class="mark-title">> 1,000,000,000</p>
      </div>
    </div>

    <div class="inlineFilterPanel" style="display:none;background:#dddddd;padding:3px;color:black;">
      Show items with Work Description including <input type="text" id="txtSearch2">
      and Total at least &nbsp;
      <div style="width:100px;display:inline-block;" id="pcSlider2"></div>
    </div>

    <md-snackbar :md-position="position" :md-duration="isInfinity ? Infinity : duration" :md-active.sync="showSnackbar"
      md-persistent>
      <span style="text-align:center;font-size:16px;line-height:1.6em;">All changes on the BoQ were undone
        successfully!</span>
    </md-snackbar>

  </div>
</template>

<style lang="scss" scoped>
.boq-header {
  height: 34px;
  padding-top: 5px;
  margin-top: 10px;
}

.boq-label {
  font-size: 16px;
}

.cell-description {
  font-weight: bold;
}

.slick-row.selected .cell-selection {
  background-color: transparent;
  /* show default selected row background */
}

/**
  * Style the drop-down menu here since the plugin stylesheet mostly contains structural CSS.
  */
.slick-header-menu {
  border: 1px solid #718BB7;
  background: #f0f0f0;
  padding: 2px;
  box-shadow: 2px 2px 2px silver;
  z-index: 20;
}

.slick-header-menuitem {
  padding: 2px 4px;
  border: 1px solid transparent;
  border-radius: 3px;
  display: block;
}

.slick-header-menuitem:hover {
  border-color: silver;
  background: white;
}

.slick-header-menuitem-disabled {
  border-color: transparent !important;
  background: inherit !important;
}

.slick-header-menuitem-hidden {
  display: none;
}

.close {
  float: right;
  font-size: 1.5rem;
  font-weight: 700;
  line-height: 1;
  color: #000;
  text-shadow: 0 1px 0 #fff;
  opacity: .5;
}

.item-details-label {
  margin-left: 10px;
  margin-top: 15px;
  display: block;
  font-weight: bold;
}

.item-details-editor-container {
  border: 1px solid silver;
  background: white;
  display: block;
  margin: 4px 10px;
  margin-top: 4px;
  padding: 0;
  padding-left: 4px;
  padding-right: 4px;
  line-height: 20px;
}

.item-details-editor-container textarea {
  height: inherit;
}

.invalid {
  color: red;
}

.item-details-editor-container.invalid {
  border: 1px solid red;
}

.item-details-validation {
  color: red;
  font-style: italic;
  margin-left: 12px;
}

.item-details-editor-container.modified {
  border: 1px solid orange;
}

.slick-large-editor-text {
  border: 1px solid #d2d2d2;
  padding: 6px;
}

.slick-large-editor-text textarea {
  width: 100%;
  height: 100%;
}

.slick-cell-checkboxsel {
  background: #f0f0f0;
  border-right-color: silver;
  border-right-style: solid;
  pointer-events: none;
}

.footer-container {
  display: flex;
  justify-content: stretch;
}

.legend {
  padding: 0px;
  display: flex;
  flex-wrap: wrap;
}

.md-content {
  width: 18px;
  height: 18px;
  margin: 8px 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.mark-title {
  margin-top: 6px;
}
</style>

<script>
import $ from 'jquery'
import Event from "./event.js";
import '@/components/EditableTable/css/jspanel.min.css'
import jsPanel from '@/components/EditableTable/js/jspanel.min.js';

const NB_COLUMNS = 17;
const E_QTY = 5;
const E_UNITPRICE = 6;
const M_QTY = 9;
const M_UNITPRICE = 10;
const L_QTY = 13;
const L_UNITPRICE = 14;
const COLTOTEQUIP = 7;
const COLTOTMATER = 11;
const COLTOTLABOR = 15;
const COLGRANDTOT = 16;
var dataView;
var grid;
var data = [];
const footerTotColIds = [COLTOTEQUIP, COLTOTMATER, COLTOTLABOR, COLGRANDTOT];
var footerTotals = {};

// Preparing the data
fetch('./resources/BoQ.json')
  .then((response) => response.json())
  .then((json) => {
    const LOT_NOS_ITEMS = 16;
    for (var i = 0; i < LOT_NOS_ITEMS; i++) {
      var d = (data[i] = {});

      d["id"] = i;
      d["num"] = i + 1;
      d["mac"] = json[i]['mac'];
      d["workDescription"] = json[i]['workDescription'];
      d["eUnit"] = json[i]['eUnit'];
      d["eQty"] = json[i]['eQty'];
      d["eUnitPrice"] = json[i]['eUnitPrice'];
      d["eTotal"] = d["eQty"] * d["eUnitPrice"];
      d["mUnit"] = json[i]['mUnit'];
      d["mQty"] = json[i]['mQty'];
      d["mUnitPrice"] = json[i]['mUnitPrice'];
      d["mTotal"] = d["mQty"] * d["mUnitPrice"];
      d["lUnit"] = json[i]['lUnit'];
      d["lQty"] = json[i]['lQty'];
      d["lUnitPrice"] = json[i]['lUnitPrice'];
      d["lTotal"] = d["lQty"] * d["lUnitPrice"];
      d["gTotal"] = d["eQty"] * d["eUnitPrice"] + d["lQty"] * d["mUnitPrice"] + d["mQty"] * d["lUnitPrice"];
    }
  });

var pickEUnitList = {
  '1': 'hrs.',
  '2': 'days'
};
var pickMUnitList = {
  '1': 'LS',
  '2': 'Set',
  '3': 'mo.',
  '4': 'no.',
  '5': 't',
  '6': 'm',
  '7': 'm2',
  '8': 'm3',
  '9': 'ml',
  '10': 'no:s'
};
var pickLUnitList = {
  '1': 'man-hr',
  '2': 'man-day'
};
// == cssClass: "cell-selection" ===
var columns = [
  { id: "sel", name: "#", field: "num", behavior: "select", width: 40, cannotTriggerInsert: true, resizable: false, selectable: false, excludeFromColumnPicker: true, sortable: true },
  { id: "mac", name: "MAC", field: "mac", width: 60, minWidth: 60, cssClass: "cell-description", editor: Slick.Editors.Text, columnGroup: "BoQ Description", sortable: true },
  { id: "workDescription", name: "Work Description", field: "workDescription", width: 250, minWidth: 120, cssClass: "cell-description", editor: Slick.Editors.Text, validator: requiredFieldValidator, columnGroup: "BoQ Description", sortable: true },
  { id: "eUnit", name: "Unit", field: "eUnit", minWidth: 55, width: 55, cssClass: "cellAlignCenter", formatter: SelectUnitFormatter, editor: SelectUnitEditor, dataSource: pickEUnitList, columnGroup: "Equipment" },
  { id: "eQty", name: "Quantity", field: "eQty", width: 60, minWidth: 60, cssClass: "cellAlignRight", formatter: numberCommaFormatter, editor: Slick.Editors.Integer, columnGroup: "Equipment" },
  { id: "eUnitPrice", name: "Unit Price", field: "eUnitPrice", width: 75, minWidth: 75, cssClass: "cellAlignRight", formatter: numberCommaFormatter, editor: Slick.Editors.Integer, columnGroup: "Equipment", sortable: true },
  { id: "eTotal", name: "Total (LAK)", field: 'eTotal', width: 86, cssClass: "cellTotalStyle", formatter: numberCommaFormatter, columnGroup: "Equipment", sortable: true },
  { id: "mUnit", name: "Unit", field: "mUnit", minWidth: 55, width: 55, cssClass: "cellAlignCenter", formatter: SelectUnitFormatter, editor: SelectUnitEditor, dataSource: pickMUnitList, columnGroup: "Material" },
  { id: "mQty", name: "Quantity", field: "mQty", width: 60, minWidth: 60, cssClass: "cellAlignRight", formatter: numberCommaFormatter, editor: Slick.Editors.Integer, columnGroup: "Material" },
  { id: "mUnitPrice", name: "Unit Price", field: "mUnitPrice", width: 75, minWidth: 75, cssClass: "cellAlignRight", formatter: numberCommaFormatter, editor: Slick.Editors.Integer, columnGroup: "Material", sortable: true },
  { id: "mTotal", name: "Total (LAK)", field: 'mTotal', width: 86, cssClass: "cellTotalStyle", formatter: numberCommaFormatter, columnGroup: "Material", sortable: true },
  { id: "lUnit", name: "Unit", field: "lUnit", minWidth: 70, width: 70, cssClass: "cellAlignCenter", formatter: SelectUnitFormatter, editor: SelectUnitEditor, dataSource: pickLUnitList, columnGroup: "Labor" },
  { id: "lQty", name: "Quantity", field: "lQty", width: 60, minWidth: 60, cssClass: "cellAlignRight", formatter: numberCommaFormatter, editor: Slick.Editors.Integer, columnGroup: "Labor" },
  { id: "lUnitPrice", name: "Unit Price", field: "lUnitPrice", width: 75, minWidth: 75, cssClass: "cellAlignRight", formatter: numberCommaFormatter, editor: Slick.Editors.Integer, columnGroup: "Labor", sortable: true },
  { id: "lTotal", name: "Total (LAK)", field: 'lTotal', width: 86, cssClass: "cellTotalStyle", formatter: numberCommaFormatter, columnGroup: "Labor", sortable: true },
  { id: "gTotal", name: "Grand Total", field: 'gTotal', width: 105, cssClass: "cellTotalStyle", formatter: highlightHiLoAmount, columnGroup: "Consolidation", sortable: true },
  {
    id: "action", name: "Action", field: "id", width: 65, resizable: false, formatter: actionFormatter, columnGroup: "Consolidation",
    cellMenu: {
      commandItems: [
        {
          command: "save-row", title: "Save Row",
          iconImage: "./images/Save.png",
          action: function (e, args) {
            // action callback.. do something
          },
          itemUsabilityOverride: function (args) {
            return (dirtyRowIds.includes(args.dataContext.id));
          },
        },
        {
          command: "cancel-row", title: "Cancel Edit Row",
          iconImage: "./images/cancel-edit.png",
          action: function (e, args) {
            // action callback.. do something
          },
          itemUsabilityOverride: function (args) {
            return (dirtyRowIds.includes(args.dataContext.id));
          },
        },
        { divider: true },
        {
          command: "delete-row", title: "Delete Row",
          iconImage: "./images/delete.png",
          cssClass: "bold", textCssClass: "font-red",
        },
      ],
    }
  }
];

var options = {
  columnPicker: {
    columnTitle: "Columns",
    hideForceFitButton: false,
    hideSyncResizeButton: false,
    forceFitTitle: "Force fit columns",
    syncResizeTitle: "Synchronous resize",
    //suppressCssChangesOnHiddenInit: true
  },
  editable: true,
  autoEdit: false,
  enableAddRow: true,
  enableCellNavigation: true,
  enableColumnReorder: true,
  createPreHeaderPanel: true,
  showPreHeaderPanel: true,
  preHeaderPanelHeight: 23,
  asyncEditorLoading: false,
  forceFitColumns: false,
  topPanelHeight: 25,
  createFooterRow: true,
  showFooterRow: true,
  footerRowHeight: 51,
  editCommandHandler: queueAndExecuteCommand,
};

var sortcol = "mac";
var sortdir = 1;
var percentCompleteThreshold = 0;
var searchString = "";
var cellMenuPlugin;
var contextMenuPlugin;
var inputMode = 0;
var commandQueue = [];
var checkboxSelector;
var dirtyRowIds = new Array();
var dirtyRows = new Array();
var oldValueRows = new Array();
var isNewItem = false;

function CreateAddlHeaderRow() {
  var $preHeaderPanel = $(grid.getPreHeaderPanel())
    .empty()
    .addClass("slick-header-columns")
    .css('left', '-1000px')
    .width(grid.getHeadersWidth());
  $preHeaderPanel.parent().addClass("slick-header");

  var headerColumnWidthDiff = grid.getHeaderColumnWidthDiff();
  var m, header, lastColumnGroup = '', widthTotal = 0;

  for (var i = 0; i < columns.length; i++) {
    m = columns[i];
    if (lastColumnGroup === m.columnGroup && i > 0) {
      widthTotal += m.width;
      header.width(widthTotal - headerColumnWidthDiff)
    } else {
      widthTotal = m.width;
      header = $("<div class='ui-state-default slick-header-column' />")
        .html("<span class='slick-column-name'>" + (m.columnGroup || '') + "</span>")
        .width(m.width - headerColumnWidthDiff)
        .appendTo($preHeaderPanel);
    }
    lastColumnGroup = m.columnGroup;
  }
}

function requiredFieldValidator(value) {
  if (value == null || value == undefined || !value.length) {
    return { valid: false, msg: "This is a required field" };
  } else {
    return { valid: true, msg: null };
  }
}

function comparer(a, b) {
  var x = a[sortcol], y = b[sortcol];
  return (x == y ? 0 : (x > y ? 1 : -1));
}

function numberCommaFormatter(row, cell, value) {
  var nf = value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
  return nf;
}

function SelectUnitFormatter(row, cell, value, columnDef, dataContext) {
  return columnDef.dataSource[value] || '-';
}

function PopulateSelect(select, dataSource, addBlank) {
  var index, len, newOption;
  if (addBlank) { select.appendChild(new Option('', '')); }
  $.each(dataSource, function (value, text) {
    newOption = new Option(text, value);
    select.appendChild(newOption);
  });
};

function SelectUnitEditor(args) {
  var $input;
  var defaultValue;
  var scope = this;
  var calendarOpen = false;
  this.keyCaptureList = [Slick.keyCode.UP, Slick.keyCode.DOWN, Slick.keyCode.ENTER];
  this.init = function () {
    $input = $('<select></select>');
    $input.width(args.container.clientWidth + 3);
    PopulateSelect($input[0], args.column.dataSource, true);
    $input.appendTo(args.container);
    $input.focus().select();
    $input.select2({
      placeholder: '', allowClear: true
    });
    $input.select2({
      minimumResultsForSearch: -1
    });
  };
  this.destroy = function () {
    $input.select2('close');
    $input.select2('destroy');
    $input.remove();
  };
  this.show = function () {
  };
  this.hide = function () {
  };
  this.position = function (position) {
  };
  this.focus = function () {
    //$input.select2('input_focus'); // A bug was raised on Composite Editor
  };
  this.loadValue = function (item) {
    defaultValue = item[args.column.field];
    $input.val(defaultValue);
    $input[0].defaultValue = defaultValue;
    $input.trigger("change.select2");
  };
  this.serializeValue = function () {
    return $input.val();
  };
  this.applyValue = function (item, state) {
    item[args.column.field] = state;
  };
  this.isValueChanged = function () {
    return (!($input.val() == "" && defaultValue == null)) && ($input.val() != defaultValue);
  };
  this.validate = function () {
    return {
      valid: true,
      msg: null
    };
  };
  this.init();
}

function plainNumberCommaFormat(value) { // Same as numberCommaFormatter function
  var nf = Intl.NumberFormat();
  return nf.format(value);
}

function highlightHiLoAmount(row, cell, value, columnDef, dataContext) {
  if (value > 1000000000) {
    return "<span class='load-red'>" + plainNumberCommaFormat(value) + "</span>";
  }
  else if (value > 500000000) {
    return "<span class='load-orange'>" + plainNumberCommaFormat(value) + "</span>";
  }
  else if (value > 100000000) {
    return "<span class='load-green'>" + plainNumberCommaFormat(value) + "</span>";
  }
  else {
    return plainNumberCommaFormat(value);
  }
}

function actionFormatter() {
  return "<div style='cursor: pointer;color: #08c;'>Action &#9660;</div>";
}

function executeCommand(e, args) {
  var activeCell = grid.getActiveCell();
  var rowIndex = activeCell && activeCell.row || 0;
  var command = args.command;
  var dataContext = args.dataContext;

  switch (command) {
    case "save-row":
      var curRow = dirtyRows.find(x => x.id === args.row);

      if (curRow == undefined) {
        return false;
      }

      var jsonData = JSON.stringify(curRow); // Very IMPORTANT step

      let url = '/update-boqitem';
      /*$.ajax({
          url: url,
          type: 'POST',
          data: jsonData,
          contentType: "application/json",
          success: function (response){
            ResetActivityToNormal(rowIndex);

            informSuccessResult('Update Work Description', 'Changes on Item No. ' + dataContext.num + ' were successfully saved.');
          },
          error: function(xhr) {
            alert(xhr.status + ': ' + xhr.responseText);
          }
      });*/

      break;
    case "cancel-row":
      var oldRow = oldValueRows.find(x => x.id === args.row);
      if (oldRow != undefined) {
        const unwantedAttr = ["id", "boqid"]
        const asArray = Object.entries(oldRow);
        const filteredRow = asArray.filter(([key, value]) => !unwantedAttr.includes(key));
        const cancelValues = Object.fromEntries(filteredRow);

        for (const key in cancelValues) {
          data[args.row][key] = oldRow[key];
        }

        CalculateESubTotal(args.row);
      }

      ResetActivityToNormal(args.row);

      break;
    case "delete-row":
      confirmDelRecord(dataContext.boqid, 'the Item No. ' + dataContext.num, 'BoQ Item', '')
        .then(function (response) {
          if (response == true) {
            let url = '/delete-boqitem/' + dataContext.boqid;
            /*$.ajax({
                url: url,
                type: 'POST',
                success: function (response){
                  UpdateAllTotals(grid);
                  informSuccessResult('Delete Item', 'Item No. ' + dataContext.num + ' was successfully deleted.');
                },
                error: function(xhr) {
                  alert(xhr.status + ': ' + xhr.responseText);
                }
            });*/

            dataView.deleteItem(dataContext.id);
          }
        });
      break;
  }
}

function confirmDelRecord(rowid, rectitle, table, extra) {
  var delRecordContent = `<div style="margin: 25px 3px">
                          <span class="fa fa-question-circle" style="display:inline-block; color:#0398E2; font-size:50px; margin:0px 10px 10px 20px; top:50%;"></span>
                          <p style="display:inline-block; line-height:26px; text-align:left; width:240px; margin:0px 0px 10px 0px;
                          font-size:1.1rem; font-style:normal; font-weight:regular;font-family:"""Open Sans""", sans-serif;">Are you sure you want to delete ` + rectitle + (extra.length != 0 ? extra : "") + `?</p>
                          <hr style="margin-top:10px; border-top: 3px solid #bbb; border-radius: 2px;">
                          <div class="btn-group" role="group" aria-label="Action" style="float:right; margin-top:6px; margin-right:30px;">
                          <button type="button" class="btn btn-warning rounded-3" id="OK" style="width:60px;">OK</button>
                          <button type="button" class="btn btn-secondary rounded-3" id="Cancel" style="width:60px;">Cancel</button>
                          </div>
                        </div>`;

  var delRecordPanel = new Promise(function (resolve, reject) {
    jsPanel.create({
      id: 'DelRecord',
      theme: 'info',
      headerControls: 'closeonly',
      iconfont: ['custom-smallify', 'custom-minimize', 'custom-normalize', 'custom-maximize', 'custom-close'],
      headerTitle: '',
      position: 'center-top 0 150 down',
      resizeit: {
        disable: true
      },
      contentSize: '340 160',
      closeOnEscape: true,
      headerLogo: '<i style="margin:0 0 0 10px"></i><span class="fa fa-trash"></span><i style="font-style:normal;margin:4px 0 4px 6px;font-size:1rem;font-weight:regular;font-family:"""Open Sans""", sans-serif;"> Delete ' + table + ' Record</i>',
      content: delRecordContent,
      callback: function (panel) {
        var response;
        let x = panel.content.querySelectorAll('button');

        for (var i = 0; i < x.length; i++) {
          switch (x[i].getAttribute("id")) {
            case "OK":
              x[i].addEventListener('click', () => {
                //location.href='/delete-record/' + table + '/' + rowid;
                response = true;
                panel.close();
                resolve(response);
              });
              break;
            case "Cancel":
              x[i].addEventListener('click', () => {
                response = false;
                panel.close();
                resolve(response);
              });
              break;
          }
        }
      }
    });
  });
  return delRecordPanel;
};

var contextMenuOptions = {
  //commandTitle: "Commands",
  commandItems: [
    {
      command: "cancel-row", title: "Cancel Edit Row", iconImage: "./images/cancel-edit.png",
      itemUsabilityOverride: function (args) {
        return (dirtyRowIds.includes(args.dataContext.id));
      }
    },
    { divider: true },
    { command: "delete-row", title: "Delete Row", iconImage: "./images/delete.png", cssClass: "bold", textCssClass: "font-red" },
  ],
};

function queueAndExecuteCommand(item, column, editCommand) {
  commandQueue.push(editCommand);
  editCommand.execute();
}

function showSnackbarFunction() {
  Event.$emit("showSnackbarMethod");
}

function undo() {
  var command = commandQueue.pop();
  if (command && Slick.GlobalEditorLock.cancelCurrentEdit()) {
    command.undo();
    grid.gotoCell(command.row, command.cell, false);
    ResetActivityToNormal(command.row);
    UpdateAllTotals(grid);
  }
}

function undoAll() {
  if (commandQueue.length == 0) return;

  while (commandQueue.length > 0) {
    undo();
  }

  showSnackbarFunction();
}

function ResetActivityToNormal(rowIndex) {
  for (var i = 0; i < dirtyRows.length; i++) {
    if (dirtyRows[i].id === rowIndex) {
      dirtyRows.splice(i, 1);
    }
  }

  for (var i = 0; i < dirtyRowIds.length; i++) {
    if (dirtyRowIds[i] === rowIndex) {
      dirtyRowIds.splice(i, 1);
    }
  }

  // Unmark as dirty row
  var selectedRowsIndexes = grid.getSelectedRows();
  var rowIndexInArr = selectedRowsIndexes.indexOf(rowIndex);
  if (rowIndexInArr >= 0) {
    selectedRowsIndexes.splice(rowIndexInArr, 1);
    grid.setSelectedRows(selectedRowsIndexes);
  }
}

function CalculateESubTotal(rowid) {
  data[rowid].eTotal = data[rowid].eQty * data[rowid].eUnitPrice;
}

function CalculateMSubTotal(rowid) {
  data[rowid].mTotal = data[rowid].mQty * data[rowid].mUnitPrice;
}

function CalculateLSubTotal(rowid) {
  data[rowid].lTotal = data[rowid].lQty * data[rowid].lUnitPrice;
}

function CalculateGrandTotal(rowid) {
  data[rowid].gTotal = data[rowid].eQty * data[rowid].eUnitPrice + data[rowid].mQty * data[rowid].mUnitPrice + data[rowid].lQty * data[rowid].lUnitPrice;
}

function UpdateAllTotals(grid) {
  UpdateTotal(COLTOTEQUIP, grid);
  UpdateTotal(COLTOTMATER, grid);
  UpdateTotal(COLTOTLABOR, grid);
  UpdateTotal(COLGRANDTOT, grid);
}

function UpdateTotal(cell, grid) {
  var columnId = columns[cell].id; // Previous: var columnId = grid.getColumns()[cell].id;
  var columnElement;

  var total = 0;
  var i = data.length;
  while (i--) {
    total += (parseInt(data[i][columnId], 10) || 0);
  }

  if (grid != undefined) {
    columnElement = grid.getFooterRowColumn(columnId);
  } else {
    columnElement = footerTotals[columnId];
  }
  $(columnElement).html("<div style='text-align:right;font-weight:bold;text-decoration:underline;color:#1a237e;'>" + plainNumberCommaFormat(total) + "</div>");
}

// For the Composite Editor to work, the current active cell must have an Editor (because it calls editActiveCell() and that only works with a cell with an Editor)
// so if current active cell doesn't have an Editor, we'll find the first column with an Editor and focus on it (from left to right starting at index 0)
function focusOnFirstCellWithEditor(columns, rowIndex) {
  var columnIndexWithEditor = 0;

  const hasEditor = columns[columnIndexWithEditor].editor;
  if (!hasEditor) {
    columnIndexWithEditor = columns.findIndex(function (col) { return col.editor });
    if (columnIndexWithEditor === -1) {
      throw new Error('We could not find any Editor in your Column Definition');
    } else {
      grid.setActiveCell(rowIndex, columnIndexWithEditor, false);
      // ======= Add by Nanthigna (24-Dec-2022) =======
      var activeCell = $(grid.getActiveCellNode());
      activeCell.click();
    }
  }
}

export default {
  name: 'BoQDetails',
  data: () => ({
    autoedit: false,
    showSnackbar: false,
    position: 'center',
    duration: 4000,
    isInfinity: false,
  }),
  methods: {
    toggleFilterRow() {
      grid.setTopPanelVisibility(!grid.getOptions().showTopPanel);
    },

    addNewBoQData() {
      //grid.setOptions({enableAddRow:true});
      //grid.invalidateAllRows();
      //grid.render();
      var rowIndex = data.length;
      focusOnFirstCellWithEditor(columns, rowIndex);
      isNewItem = true;
    },

    toggle() {
      if (this.autoedit == true) {
        grid.setOptions({ autoEdit: true });
      } else {
        grid.setOptions({ autoEdit: false });
      };

      grid.invalidateAllRows();
      grid.render();
      UpdateAllTotals(grid);
    },

    async showSnackbarMethod() {
      this.showSnackbar = true;
    },

  },
  mounted() {
    var checkboxSelector = new Slick.CheckboxSelectColumn({
      cssClass: "slick-cell-checkboxsel",
      hideSelectAllCheckbox: true,
      freezeCheckBox: true, // Added By Nanthigna (04-Dec-2022)
      selectableOverride: function (row, dataContext, grid) {
        return (dirtyRowIds.includes(dataContext.id));
      }
    });

    if (columns.length == NB_COLUMNS) {
      columns.unshift(checkboxSelector.getColumnDefinition());
      columns[0].header = {
        buttons: [
          {
            image: "../images/undo2.png",
            showOnHover: true,
            tooltip: "Undo all changes",
            handler: function (e) {
              undoAll();
            }
          }
        ]
      };

      let colIndex = [3]; // Work Description column(s)
      for (const i of colIndex) {
        columns[i].header = {
          buttons: [
            {
              cssClass: "icon-inline",
              image: "../images/drag-handle.png",
              command: "toggle-inputItems",
              tooltip: "Toggle between in-line/in-form input modes.",
            }
          ]
        };
      }
    }

    dataView = new Slick.Data.DataView({ inlineFilters: true });
    grid = new Slick.Grid("#myGrid", dataView, columns, options);

    grid.onColumnsResized.subscribe(function (e, args) {
      CreateAddlHeaderRow();
    });
    CreateAddlHeaderRow();

    grid.onColumnsReordered.subscribe(function (e, args) {
      //UpdateAllTotals(args.grid);
    });

    grid.setSelectionModel(new Slick.RowSelectionModel({ selectActiveRow: false }));
    grid.registerPlugin(checkboxSelector);

    grid.registerPlugin(new Slick.AutoTooltips({ enableForHeaderCells: true }));
    grid.render();
    $(document).tooltip({ tooltipClass: "slick-tooltip" });

    var pager = new Slick.Controls.Pager(dataView, grid, $("#pager"));
    var columnpicker = new Slick.Controls.ColumnPicker(columns, grid, options);

    Event.$on("showSnackbarMethod", group => {
      this.showSnackbarMethod();
    });

    grid.onAddNewRow.subscribe(function (e, args) {
      var item = {
        "id": data.length + 1,
        "num": data.length + 1,
        "mac": "",
        "workDescription": "New Item",
        "eUnit": -1,
        "eQty": 1,
        "eUnitPrice": 0,
        "eTotal": 0,
        "mUnit": -1,
        "mQty": 1,
        "mUnitPrice": 0,
        "mTotal": 0,
        "lUnit": -1,
        "lQty": 1,
        "lUnitPrice": 0,
        "lTotal": 0,
        "gTotal": 0
      };

      $.extend(item, args.item);
      dataView.addItem(item);
    });

    $(".grid-header .ui-icon")
      .addClass("ui-state-default ui-corner-all")
      .mouseover(function (e) {
        $(e.target).addClass("ui-state-hover")
      })
      .mouseout(function (e) {
        $(e.target).removeClass("ui-state-hover")
      });

    var headerButtonsPlugin = new Slick.Plugins.HeaderButtons();

    headerButtonsPlugin.onCommand.subscribe(function (e, args) {
      var column = args.column;
      var button = args.button;
      var command = args.command;
      const inputEditorColumn = { "workDescription": 3 };
      var i = inputEditorColumn[column.id];

      if (command == "toggle-inputItems") {
        if (button.cssClass == "icon-inline") {
          button.image = "../images/web-form.png";
          button.cssClass = "icon-inform";
          button.tooltip = "Toggle to in-line input mode";

          columns[i].editor = Slick.Editors['LongText'];
        } else {
          button.image = "../images/drag-handle.png";
          button.cssClass = "icon-inline";
          button.tooltip = "Toggle to in-form input mode";

          columns[i].editor = Slick.Editors['Text'];
        }

        grid.invalidate();
      }
    });

    grid.registerPlugin(headerButtonsPlugin);

    // move the filter panel defined in a hidden div into grid top panel
    $(".inlineFilterPanel")
      .appendTo(grid.getTopPanel())
      .show();

    grid.onCellChange.subscribe(function (e, args) {
      var curRowId = args.row;

      switch (args.cell) {
        case E_QTY: // 'eQty' column
        case E_UNITPRICE: // 'eUnitPrice' column
          CalculateESubTotal(curRowId);
          UpdateTotal(COLTOTEQUIP, args.grid);
          grid.updateRow(curRowId);
          break;
        case M_QTY: // 'mQty' column
        case M_UNITPRICE: // 'mUnitPrice' column
          CalculateMSubTotal(curRowId);
          UpdateTotal(COLTOTMATER, args.grid);
          grid.updateRow(curRowId);
          break;
        case L_QTY: // 'lQty' column
        case L_UNITPRICE: // 'lUnitPrice' column
          CalculateLSubTotal(curRowId);
          UpdateTotal(COLTOTLABOR, args.grid);
          grid.updateRow(curRowId);
          break;
      }

      CalculateGrandTotal(curRowId);
      UpdateTotal(COLGRANDTOT, args.grid);
      dataView.updateItem(args.item.id, args.item);
    });

    grid.onKeyDown.subscribe(function (e, args) {
      switch (args.cell) {
        case E_QTY: // 'eQty' column
        case E_UNITPRICE: // 'eUnitPrice' column
        case M_QTY: // 'mQty' column
        case M_UNITPRICE: // 'mUnitPrice' column
        case L_QTY: // 'lQty' column
        case L_UNITPRICE: // 'lUnitPrice' column
          OnlyIntegers(e);
          break;
      }
      // select all rows on ctrl-a
      if (e.which != 65 || !e.ctrlKey) {
        return false;
      }

      var rows = [];
      for (var i = 0; i < dataView.getLength(); i++) {
        rows.push(i);
      }

      grid.setSelectedRows(rows);
      e.preventDefault();
    });

    grid.onSort.subscribe(function (e, args) {
      sortdir = args.sortAsc ? 1 : -1;
      sortcol = args.sortCol.field;

      // using native sort with comparer
      // preferred method but can be very slow in IE with huge datasets
      dataView.sort(comparer, args.sortAsc);
    });

    dataView.onRowCountChanged.subscribe(function (e, args) {
      grid.updateRowCount();
      grid.render();
    });

    dataView.onRowsChanged.subscribe(function (e, args) {
      UpdateAllTotals(args.grid);
      grid.invalidateRows(args.rows);
      grid.render();
    });

    function GetRowData(rowid) {
      var rowData = {
        "id": data[rowid].id,
        "num": data[rowid].num,
        "mac": data[rowid].mac,
        "workDescription": data[rowid].workDescription,
        "eUnit": data[rowid].eUnit,
        "eQty": data[rowid].eQty,
        "eUnitPrice": data[rowid].eUnitPrice,
        "mUnit": data[rowid].mUnit,
        "mQty": data[rowid].mQty,
        "mUnitPrice": data[rowid].mUnitPrice,
        "lUnit": data[rowid].mUnit,
        "lQty": data[rowid].mQty,
        "lUnitPrice": data[rowid].mUnitPrice,
      }

      return rowData;
    }

    function MarkAsDirty(rowIndex) {
      var selectedRowsIndexes = grid.getSelectedRows();
      dirtyRowIds.push(rowIndex);

      if (selectedRowsIndexes.indexOf(rowIndex) < 0) {
        selectedRowsIndexes.push(rowIndex);
        grid.setSelectedRows(selectedRowsIndexes);
      }
    }

    grid.onBeforeEditCell.subscribe(function (e, args) {
      if (isNewItem == true) { return; }
      if (oldValueRows.find(x => x.id === args.row) == undefined) {
        var curOldRow = {};
        curOldRow = GetRowData(args.row);

        oldValueRows.push(curOldRow);
      }
    });

    grid.onCellChange.subscribe(function (e, args) {
      if (isNewItem == true) { return; }
      var curRow = dirtyRows.find(x => x.id === args.row);
      if (curRow == undefined) {
        dirtyRows.push(new GetRowData(args.row));
        MarkAsDirty(args.row);
      } else {
        var curColName = args.column.id;

        curRow[curColName] = data[args.row][curColName]
      }
    });

    dataView.onPagingInfoChanged.subscribe(function (e, pagingInfo) {
      grid.updatePagingStatusFromView(pagingInfo);

      // show the pagingInfo but remove the dataView from the object, just for the Cypress E2E test
      delete pagingInfo.dataView;
      console.log('on After Paging Info Changed - New Paging:: ', pagingInfo);
    });

    dataView.onBeforePagingInfoChanged.subscribe(function (e, previousPagingInfo) {
      // show the previous pagingInfo but remove the dataView from the object, just for the Cypress E2E test
      delete previousPagingInfo.dataView;
      console.log('on Before Paging Info Changed - Previous Paging:: ', previousPagingInfo);
    });

    // === To make "Footer Totals" visible, put it here (After all subscriptions) ===
    UpdateAllTotals(grid);

    footerTotColIds.forEach(function (item, index) {
      var columnId = columns[item].id;
      footerTotals[columnId] = grid.getFooterRowColumn(item);
    });


    var h_runfilters = null;

    // wire up the slider to apply the filter to the model
    $("#pcSlider,#pcSlider2").slider({
      "range": "min",
      "slide": function (event, ui) {
        Slick.GlobalEditorLock.cancelCurrentEdit();

        if (percentCompleteThreshold != ui.value) {
          window.clearTimeout(h_runfilters);
          h_runfilters = window.setTimeout(updateFilter, 10);
          percentCompleteThreshold = ui.value;
        }
      }
    });

    // wire up the search textbox to apply the filter to the model
    $("#txtSearch,#txtSearch2").keyup(function (e) {
      Slick.GlobalEditorLock.cancelCurrentEdit();

      // clear on Esc
      if (e.which == 27) {
        this.value = "";
      }

      searchString = this.value;
      updateFilter();
    });

    function myFilter(item, args) {
      if (args.searchString != "" && item["workDescription"].indexOf(args.searchString) == -1) {
        return false;
      }

      return true;
    }

    function updateFilter() {
      dataView.setFilterArgs({
        percentCompleteThreshold: percentCompleteThreshold,
        searchString: searchString
      });
      dataView.refresh();
    }

    function OnlyIntegers(event) {
      var key = event.keyCode ? event.keyCode : event.which;

      if (!([8, 9, 13, 27, 46, 110].indexOf(key) !== -1 ||
        (key == 65 && (event.ctrlKey || event.metaKey)) ||
        (key >= 35 && key <= 40) ||
        (key >= 48 && key <= 57 && !(event.shiftKey || event.altKey)) ||
        (key >= 96 && key <= 105)
      )) event.preventDefault();
    };

    $("#btnSelectRows").click(function () {
      if (!Slick.GlobalEditorLock.commitCurrentEdit()) {
        return;
      }

      var rows = [];
      for (var i = 0; i < 10 && i < dataView.getLength(); i++) {
        rows.push(i);
      }

      grid.setSelectedRows(rows);
    });

    // initialize the model after all the events have been hooked up
    dataView.beginUpdate();
    dataView.setItems(data);
    dataView.setFilterArgs({
      percentCompleteThreshold: percentCompleteThreshold,
      searchString: searchString
    });
    dataView.setFilter(myFilter);
    dataView.endUpdate();

    // if you don't want the items that are not visible (due to being filtered out
    // or being on a different page) to stay selected, pass 'false' to the second arg
    dataView.syncGridSelection(grid, true);

    $("#gridContainer").resizable();

    cellMenuPlugin = new Slick.Plugins.CellMenu({ hideMenuOnScroll: true });
    contextMenuPlugin = new Slick.Plugins.ContextMenu(contextMenuOptions);
    grid.registerPlugin(cellMenuPlugin);
    grid.registerPlugin(contextMenuPlugin);

    grid.onClick.subscribe(function (e) {
      var cell = grid.getCellFromEvent(e);

      if (cell.row == data.length) {
        isNewItem = true;
        return;
      }
    });

    grid.setActiveCell(0, 1);

    contextMenuPlugin.onBeforeMenuShow.subscribe(function (e, args) {
      // grid.setSelectedRows([args.row]); // select the entire row
      grid.setActiveCell(args.row, args.cell, false); // select the cell that the click originated
      //console.log("Before the global Context Menu is shown", args);
    });
    contextMenuPlugin.onBeforeMenuClose.subscribe(function (e, args) {
      //console.log("Global Context Menu is closing", args);
    });

    contextMenuPlugin.onAfterMenuShow.subscribe(function (e, args) {
      // grid.setSelectedRows([args.row]); // select the entire row
      grid.setActiveCell(args.row, args.cell, false); // select the cell that the click originated
      //console.log("After the Context Menu is shown", args);
    });

    contextMenuPlugin.onCommand.subscribe(function (e, args) {
      // e.preventDefault(); // you could do if you wish to keep the menu open
      executeCommand(e, args);
    });

    cellMenuPlugin.onBeforeMenuShow.subscribe(function (e, args) {
      //console.log("Before the Cell Menu is shown", args);
      //$("#contextMenu").hide();
    });

    cellMenuPlugin.onBeforeMenuClose.subscribe(function (e, args) {
      //console.log("Cell Menu is closing", args);
    });

    cellMenuPlugin.onAfterMenuShow.subscribe(function (e, args) {
      grid.setActiveCell(args.row, args.cell, false);
    });

    cellMenuPlugin.onCommand.subscribe(function (e, args) {
      executeCommand(e, args);
    });
  }
}
</script>