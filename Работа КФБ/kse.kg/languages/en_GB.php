<?php
$_LANG["{DbConnectionError}"] = "Coult not connect to database";
$_LANG["{DatabaseNotExistsError}"] = "Database does not exists";
$_LANG["{UnknownLanguage}"] = "Unknown language";
$_LANG["{UnknownPageTitle}"] = "Page does't exist";
$_LANG["{UnknownPageText}"] = "Page does't exist. You can.";
if (isset($_SESSION["LOGGED"])) {
    $_LANG["{UnknownPageText}"].= " Вы можете <a href=\"" .
    MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" . $_SESSION["LANGUAGE"] .
    "/NewPage/" . MainClass::getSingleton()->getPageName()
    . "\">create new page</a> with that name.";
}

// Errors
$_LANG["{BadLoginOrPassword}"] = "Wrong username or password";
$_LANG["{AvailableForLoggedUser}"] = "Request operation is available only for registered users
<a href=\"" .
MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" . $_SESSION["LANGUAGE"] .
"/Login\">Sign in</a> | <a href=\"" .
MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" . $_SESSION["LANGUAGE"] .
"/Register\">Register</a>";

$_LANG["{PageMustBeUnique}"] = "System name should be unique";
$_LANG["{UnknownPageHandler}"] = "Unknown page handler";
$_LANG["{UnknownPageModule}"] = "Module was not found";
$_LANG["{LoginOrEmailAlreadyExists}"] = "User with that login or email is already registered";
$_LANG["{LoginIsBad}"] = "Логин не соответствует требованиям длины (6-32 символов)";
$_LANG["{EmailIsBad}"] = "Bad E-mail";
$_LANG["{PasswordIsBad}"] = "Пароль должен быть не менее шести символов";
$_LANG["{PasswordsMismatch}"] = "Password mismatch";
$_LANG["{BadModuleParameters}"] = "Module is awaiting for parameters.";


// Messages
$_LANG["{PageSuccessfullyEdited}"] = "Changes saved";
$_LANG["{PageSuccessfullyRenamed}"] = "Page was renamed";
$_LANG["{SuccessfullyRegistered}"] = "Вы были успешно заристрированы. Используйте свои логин и пароль для входа в систему";

// interface
$_LANG["{LogInButton}"] = "Sign in";
$_LANG["{doLogIn}"] = "Enter";
$_LANG["{doCancel}"] = "Cancel";
$_LANG["{doRegister}"] = "Register";
$_LANG["{RegisterButton}"] = "Register";

// blog module
$_LANG["{PeriodFrom}"] = "From";
$_LANG["{PeriodTo}"] = "To";
$_LANG["{DoCreateBlog}"] = "Create new blog";
$_LANG["{BlogName}"] = "Blog name";
$_LANG["{doCreateBlog}"] = "Create";
$_LANG["{BlogAlreadyExists}"] = "Блог с таким системным именем уже существует. Системное имя должно быть уникальным";
$_LANG["{BlogControlPanel}"] = "Панель управления";
$_LANG["{BlogWasNotFound}"] = "Блог не найден";
$_LANG["{BlogWasNotFoundDescription}"] = "Запрошенный блог не был найден. Возможно он еще не создан, либо уже удален.";
$_LANG["{AllNews}"] = "All news";

// tradestat module
$_LANG["{DailyTradeResults}"] = "Trade results";
$_LANG["{MlnSom}"] = "mln. som";
$_LANG["{TotalVolume}"] = "Total Volume";
$_LANG["{PrimaryMarket}"] = "Primary market";
$_LANG["{SecondaryMarket}"] = "Secondary market";
$_LANG["{ListingStocks}"] = "Listing";
$_LANG["{NonListingStocks}"] = "Non listing";

//Listing Module
$_LANG["{CompanyWasNotFound}"] = "Requested company was not found";

// From templates
$_LANG["{temp_about}"] = "About";
$_LANG["{temp_general_info}"] = "General Information";
$_LANG["{temp_our_strategy}"] = "Development Strategy";
$_LANG["{temp_corporate_documents}"] = "Corporate Documents";
$_LANG["{temp_auctioneers}"] = "Shareholders";
$_LANG["{temp_members}"] = "Markets Participants";
$_LANG["{temp_partners}"] = "Our Partners";
$_LANG["{temp_management}"] = "Board of Directors";
$_LANG["{temp_revisory}"] = "Revisory Committee";
$_LANG["{temp_standards}"] = "Regulatory Base";
$_LANG["{temp_kse_normatives}"] = "Exchange Activities";
$_LANG["{temp_depo_normatives}"] = "Depositary Activities";
$_LANG["{temp_statistics}"] = "Trade Statistics";
$_LANG["{temp_trade_results}"] = "Results of Recent Trades";
$_LANG["{temp_archive}"] = "Trade Archive";
$_LANG["{temp_index_and_capitalization}"] = "Index and Market Capitalisation";
$_LANG["{temp_quotes}"] = "Quotes";
$_LANG["{temp_study_center}"] = "Training Centre";
$_LANG["{temp_education}"] = "General Information";
$_LANG["{temp_edu_plan}"] = "Annual Work Plan";

$_LANG["{temp_Committees}"] = "Committees";
$_LANG["{temp_ListingCommittee}"] = "Listing Committee";
$_LANG["{temp_StrategicPlanningCommittee}"] = "Committee of the Board of Directors for Strategic Planning and Corporate Development";
$_LANG["{temp_AuditCommittee}"] = "Audit and Remuneration Committee of the Board of Directors";

$_LANG["Last Trade Results"] = "Last Trade Results";
$_LANG["Trades for"] = "Trades for";
$_LANG["{Trades Volume}"] = "Volume";
$_LANG["{Primary Market}"] = "Primary";
$_LANG["{Secondary Market}"] = "Secondary";
$_LANG["{Listing}"] = "Listing";
$_LANG["{Non Listing}"] = "Non-Listing";
$_LANG["{Table}"] = "Table";
$_LANG["{Chart}"] = "Chart";
$_LANG["{Trade results for}"] = "Trade results for";


$_LANG["{January}"] = "January";
$_LANG["{February}"] = "February";
$_LANG["{March}"] = "March";
$_LANG["{April}"] = "April";
$_LANG["{May}"] = "May";
$_LANG["{June}"] = "June";
$_LANG["{July}"] = "Jule";
$_LANG["{August}"] = "August";
$_LANG["{September}"] = "September";
$_LANG["{October}"] = "October";
$_LANG["{November}"] = "November";
$_LANG["{December}"] = "December";



// Last trade
$_LANG["Forweek"]="For week";
$_LANG["For"]="For";
$_LANG["month"]="month";
$_LANG["year"]="year";
$_LANG["{Period}"] = "Period:";
$_LANG["{Last trade}"] = "Last trade";
$_LANG["Formonth"]="For month";
$_LANG["Foryear"]="For year";

// Index and capitalization
$_LANG["indexcapitalization"]="Index and Capitalization";
$_LANG["indexon"]="Index on";
$_LANG["{index}"]="Index";
$_LANG["{capitalizationMlnsom}"]="Capitalization (mln.som)";
$_LANG["{capitalization}"]="Capitalization";
$_LANG["{indexfor}"]="Index for";
$_LANG["{capitalizationfor}"]="Capitalization for";
$_LANG["{yearz}"]="year*";
$_LANG["{vmlnsom}"]="*in mln. som";
$_LANG["{god}"]="year";

// TradeResults
$_LANG["curname"]="Name";
$_LANG["tradesymbol"]="Trade symbol";
$_LANG["maxprice"]="Max price, som";
$_LANG["minprice"]="Min price, som";
$_LANG["tradevolume"]="Trade volume, ths.som";
$_LANG["amountoftransactions"]="Amount of Transactions";
$_LANG["amountofsecurities"]="Amount of Securities";

// TradeArchive
$_LANG["totaltradevolume"]="Total trade volume, ths. som";
$_LANG["amountofsecuritiespiece"]="Amount of Securities piece";
$_LANG["tradesprimary"]="Trades on the primary market, ths. som";
$_LANG["tradessecond"]="Trades on the secondary market, ths. som";
$_LANG["tradeslisted"]="Trades on the sector of listed securities, ths. som";
$_LANG["tradesnonlisted"]="Trades on the sector of non-listed securities, ths. som";
$_LANG["currentyear"]="For current year";
$_LANG["lastyear"]="For last year";
$_LANG["onyear"]="On years";
$_LANG["tradearchive"]="Trade Archive";
$_LANG["total"]="Total:";

// Quotes
$_LANG["qname"]="Name";
$_LANG["salequantity"]="Sell: quantity";
$_LANG["buyquantity"]="Buy: quantity";
$_LANG["saleprice"]="Sell: price";
$_LANG["buyprice"]="Buy: price";

$_LANG["indeces"]="Indices:";
$_LANG["valueson"]="Values on";
$_LANG["currency"]="Currency";
$_LANG["registration"]="Registration course NBKR on:";

// buysell
$_LANG["byesell"]="In this section any interested person can make an request on sale or buying of securities on a platform of CJSC  Kyrgyz Stock Exchange . Right after fillings of the form of the request  - the information specified by you will be sent in the broker companies which representatives in the minimal terms will contact with you on the contact data specified by you.";
$_LANG["operaciya"]="Transaction:";
$_LANG["bumaga"]="Stock:";
$_LANG["cena"]="Price:";
$_LANG["kolvo"]="Amount:";
$_LANG["comment"]="Comments (here you can leave the contact data):";
$_LANG["cod"]="Code on the picture:";
$_LANG["kuplyaprodazha"]="Buy/Sale of securities";
$_LANG["prodazha"]="Sell";
$_LANG["pokupka"]="Buy";