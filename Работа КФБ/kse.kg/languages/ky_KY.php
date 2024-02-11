<?php
$_LANG["{DbConnectionError}"] = "Не удалось подключиться к базе данных";
$_LANG["{DatabaseNotExistsError}"] = "Не удалось загрузить базу данных";
$_LANG["{UnknownLanguage}"] = "Был запрошен неизвестный языковой пакет";
$_LANG["{UnknownPageTitle}"] = "Страница не существует";
$_LANG["{UnknownPageText}"] = "Страница, которую Вы запросили не существует.";
if (isset($_SESSION["LOGGED"])) {
    $_LANG["{UnknownPageText}"].= " Вы можете <a href=\"" .
    MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" . $_SESSION["LANGUAGE"] .
    "/NewPage/" . MainClass::getSingleton()->getPageName()
    . "\">создать страницу</a> с таким именем.";
}

// Errors
$_LANG["{BadLoginOrPassword}"] = "Неверное имя пользователя или пароль";
$_LANG["{AvailableForLoggedUser}"] = "Запрошенная операция доступна только зарегистрированным пользователям
<a href=\"" .
MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" . $_SESSION["LANGUAGE"] .
"/Login\">Вход</a> | <a href=\"" .
MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" . $_SESSION["LANGUAGE"] .
"/Register\">Регистрация</a>";

$_LANG["{PageMustBeUnique}"] = "Системное имя элемента должно быть уникальным";
$_LANG["{UnknownPageHandler}"] = "Запрошен несуществующий обработчик страниц";
$_LANG["{UnknownPageModule}"] = "Проблема при загрузке модуля: Модуль не найден";
$_LANG["{LoginOrEmailAlreadyExists}"] = "Пользователь с таким логином или электронным адресом уже зарегистрирован.
    Выберите другой";
$_LANG["{LoginIsBad}"] = "Логин не соответствует требованиям длины (6-32 символов)";
$_LANG["{EmailIsBad}"] = "Некорректный электронный адрес";
$_LANG["{PasswordIsBad}"] = "Пароль должен быть не менее шести символов";
$_LANG["{PasswordsMismatch}"] = "Пароли не совпадают";
$_LANG["{BadModuleParameters}"] = "Один из модулей на этой странице не получил ожидаемых параметров.";


// Messages
$_LANG["{PageSuccessfullyEdited}"] = "Изменения сохранены";
$_LANG["{PageSuccessfullyRenamed}"] = "Страница успешно переименована";
$_LANG["{SuccessfullyRegistered}"] = "Вы были успешно заристрированы. Используйте свои логин и пароль для входа в систему";

// interface
$_LANG["{LogInButton}"] = "Вход";
$_LANG["{doLogIn}"] = "Войти";
$_LANG["{doCancel}"] = "Отмена";
$_LANG["{doRegister}"] = "Зарегистрировать";
$_LANG["{RegisterButton}"] = "Регистрация";


// blog module
$_LANG["{DoCreateBlog}"] = "Создать новый блог";
$_LANG["{BlogName}"] = "Название блога";
$_LANG["{doCreateBlog}"] = "Создать блог";
$_LANG["{BlogAlreadyExists}"] = "Блог с таким системным именем уже существует. Системное имя должно быть уникальным";
$_LANG["{BlogControlPanel}"] = "Панель управления";
$_LANG["{BlogWasNotFound}"] = "Блог не найден";
$_LANG["{BlogWasNotFoundDescription}"] = "Запрошенный блог не был найден. Возможно он еще не создан, либо уже удален.";

// tradestat module
$_LANG["{DailyTradeResults}"] = "Итоги торгов";
$_LANG["{MlnSom}"] = "Млн. сом";
$_LANG["{TotalVolume}"] = "Общий объем";
$_LANG["{PrimaryMarket}"] = "Первичный рынок";
$_LANG["{SecondaryMarket}"] = "Вторичный рынок";
$_LANG["{ListingStocks}"] = "Листинг";
$_LANG["{NonListingStocks}"] = "Не листинг";

//Listing Module
$_LANG["{CompanyWasNotFound}"] = "Запрошенная компания не была найдена";

// From templates
$_LANG["{temp_about}"] = "Биржа жөнүндө";
$_LANG["{temp_general_info}"] = "Жалпы маалымат";
$_LANG["{temp_our_strategy}"] = "Өнүгүү стратегиясы";
$_LANG["{temp_corporate_documents}"] = "Корпоративдик иш-кагаздары";
$_LANG["{temp_auctioneers}"] = "Акционерлер";
$_LANG["{temp_members}"] = "Тооруктун катышуучулары";
$_LANG["{temp_partners}"] = "Биздин өнөктөштөр";
$_LANG["{temp_management}"] = "Директорлор кенеши";
$_LANG["{temp_revisory}"] = "Ревизиялык комисиясы";
$_LANG["{temp_standards}"] = "Нормативдик база";
$_LANG["{temp_kse_normatives}"] = "Биржалык иш-аракеттер";
$_LANG["{temp_depo_normatives}"] = "Депозитардык иш-аракеттер";
$_LANG["{temp_statistics}"] = "Тооруктардын статистикасы";
$_LANG["{temp_trade_results}"] = "Акыркы тооруктардын натыйжалары";
$_LANG["{temp_archive}"] = "Тоорук архиви";
$_LANG["{temp_index_and_capitalization}"] = "Индекс жана Капиталдаштыруу";
$_LANG["{temp_quotes}"] = "Котировкалар";
$_LANG["{temp_study_center}"] = "Окуу борбору";
$_LANG["{temp_education}"] = "Жалпы маалымат";
$_LANG["{temp_edu_plan}"] = "Жылдык иш-чаралардын планы";
$_LANG["{temp_open_information}"] = "Маалымат ачуу борбору";


$_LANG["{Monday}"] = "Понедельник";
$_LANG["{Tuesday}"] = "Вторник";
$_LANG["{Wednesday}"] = "Среда";
$_LANG["{Thursday}"] = "Четверг";
$_LANG["{Friday}"] = "Пятница";
$_LANG["{Saturday}"] = "Суббота";
$_LANG["{Sunday}"] = "Воскресенье";

$_LANG["{January}"] = "Январь";
$_LANG["{February}"] = "Февраль";
$_LANG["{March}"] = "Март";
$_LANG["{April}"] = "Апрель";
$_LANG["{May}"] = "Май";
$_LANG["{June}"] = "Июнь";
$_LANG["{July}"] = "Июль";
$_LANG["{August}"] = "Август";
$_LANG["{September}"] = "Сентябрь";
$_LANG["{October}"] = "Октябрь";
$_LANG["{November}"] = "Ноябрь";
$_LANG["{December}"] = "Декабрь";

// Blog Module
$_LANG["{ForPeriod}"] = " За период";
$_LANG["{PeriodFrom}"] = "С";
$_LANG["{PeriodTo}"] = "По";
$_LANG["{TotalPages}"] = "Всего страниц";
$_LANG["{DisplayNews}"] = "Показать";
$_LANG["{AllNews}"] = "Все новости";

$_LANG["Last Trade Results"] = "Итоги последних сделок";
$_LANG["Trades for"] = "Торги за";
$_LANG["{Trades Volume}"] = "Объем торгов";
$_LANG["{Primary Market}"] = "Первичный";
$_LANG["{Secondary Market}"] = "Вторичный";
$_LANG["{Listing}"] = "Листинг";
$_LANG["{Non Listing}"] = "Нелистинг";
$_LANG["{Table}"] = "Таблица";
$_LANG["{Chart}"] = "График";
$_LANG["{Trade results for}"] = "Итоги торгов за";

// Last trade
$_LANG["Forweek"]="За неделю";
$_LANG["For"]="За";
$_LANG["month"]="месяц";
$_LANG["year"]="год";
$_LANG["{Period}"] = "Период:";
$_LANG["{Last trade}"] = "Последние торги";
$_LANG["Formonth"]="За месяц";
$_LANG["Foryear"]="За год";

// Index and capitalization
$_LANG["indexcapitalization"]="Индекс и Капитализация";
$_LANG["indexon"]="Индекс на";
$_LANG["{index}"]="Индекс";
$_LANG["{capitalizationMlnsom}"]="Капитализация (млн.сом)";
$_LANG["{capitalization}"]="Капитализация";
$_LANG["{indexfor}"]="Индекс за";
$_LANG["{capitalizationfor}"]="Капитализация за";
$_LANG["{yearz}"]="год*";
$_LANG["{vmlnsom}"]="*в млн. сом";
$_LANG["{god}"]="год";
$_LANG["{temp_members_rating}"] = "Тооруктун катышуучуларынын рейтинги";

// TradeResults
$_LANG["curname"]="Наименования компании, вид ЦБ";
$_LANG["tradesymbol"]="Торговый символ";
$_LANG["maxprice"]="Max цена, сом";
$_LANG["minprice"]="Min цена, сом";
$_LANG["tradevolume"]="Объем торгов, тыс. сом";
$_LANG["amountoftransactions"]="Кол-во сделок";
$_LANG["amountofsecurities"]="Кол-во ЦБ";


// TradeArchive
$_LANG["totaltradevolume"]="Общий объем торгов, тыс. сом";
$_LANG["amountofsecuritiespiece"]="Кол-во ценных бумаг шт.";
$_LANG["tradesprimary"]="Торги на первичном рынке, тыс. сом";
$_LANG["tradessecond"]="Торги на вторичном рынке, тыс. сом";
$_LANG["tradeslisted"]="Торги в секторе листинговых ЦБ, тыс. сом";
$_LANG["tradesnonlisted"]="Торги в секторе не листинговых ЦБ, тыс. сом";
$_LANG["currentyear"]="За текущий год";
$_LANG["lastyear"]="За прошлый год";
$_LANG["onyear"]="По годам";
$_LANG["tradearchive"]="Архив торгов";
$_LANG["total"]="Итого:";

// Quotes
$_LANG["qname"]="Наименование";
$_LANG["salequantity"]="Предложения на продажу";
$_LANG["buyquantity"]=" Заявка на покупку";
$_LANG["qprice"]="цена";
$_LANG["qquantity"]="кол-во";

$_LANG["indeces"]="Индекстер:";
$_LANG["valueson"]="";
$_LANG["currency"]="Валюта курсу";
$_LANG["registration"]="КРУБнын эсептик курсу";


// Buysell
$_LANG["byesell"]="В этом разделе любой желающий может подать заявку на продажу или покупку ценных
бумаг на площадке ЗАО Кыргызская Фондовая Биржа. Сразу после заполнения формы
заявки - информация указанная Вами будет отправлена в брокерские компании,
представители которых в минимальные сроки свяжутся с ваим по указанным вами
контактным данным.";
$_LANG["operaciya"]="Операция:";
$_LANG["bumaga"]="Ценная бумага:";
$_LANG["cena"]="Цена:";
$_LANG["kolvo"]="Количество:";
$_LANG["comment"]="Комментарии (здесь вы можете оставить свои контактные данные):";
$_LANG["cod"]="Код на картинке:";
$_LANG["kuplyaprodazha"]="Купля/Продажа ценных бумаг";
$_LANG["prodazha"]="Продажа";
$_LANG["pokupka"]="Покупка";
