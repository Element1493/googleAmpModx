# googleAmpModx

Простой плагин AMP для переключение и автоматическое формирование в AMP контент. Для автоматический изменения контента, была внедрена Библиотека: **[AMP PHP Library](https://github.com/Lullabot/amp-library)**

### Системные настройки
Ключ| Название|По умолчанию
-|-|-
**googleAmpModx_cache**    | Кэширование для AMP контента|**Да**
**googleAmpModx_get** 	   | Имя запроса|**amp**
**googleAmpModx_template** | AMP шаблон по умолчанию, если не указан id в запросе|**0**
**googleAmpModx_warnings** | Вывести результат в Журнале ошибок|**Нет**

### Инструкция
**1.** Создаем шаблон AMP Страницы:
```html
<!DOCTYPE html>
<html amp lang="ru">
<head>
    <meta charset="utf-8">
    <title>[[*pagetitle]]</title>
	<link rel="canonical" href="/">
	<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
	<style amp-boilerplate> 
		body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{ visibility:hidden}to{ visibility:visible}}@-moz-keyframes -amp-start{ from{ visibility:hidden}to{ visibility:visible}}@-ms-keyframes -amp-start{from{ visibility:hidden}to{ visibility:visible}}@-o-keyframes -amp-start{ from{ visibility:hidden}to{ visibility:visible}}@keyframes -amp-start{ from{visibility:hidden}to{visibility:visible}}
	</style>
	<noscript><style amp-boilerplate>body{ -webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
	<script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
    <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
</head>
<body>
	<amp-sidebar id="sidebar" layout="nodisplay">
		<div role="button" on="tap:sidebar.close" tabindex="5" class="close">×</div>
		<ul>
			<li role="navigation" tabindex="1"><a href="/" title="Главная страница">Главная страница</a></li>
		</ul>
	</amp-sidebar>	
	<div id="header">
		<a href="[[++site_url]]" title="[[*pagetitle:escape]]">
			<amp-img src="[[++site_url]]logo.svg" alt="[[*pagetitle:escape]]" width="200" height="40" style="float:right"></amp-img>
		</a>
		<div role="button" on="tap:sidebar.toggle" tabindex="0" id="ham">☰</div>
	</div>
	<div style="margin: 10px;">
		<h1>[[*pagetitle]]</h1>
		[[*content]]
	</div>
	<div id="footer">
		
	</div>
</body>
</html>
```
**2.** Если у вас один шаблон, то к ссылке дописываем запрос `?amp`, не забудьте поменять в <u>Системных настройках</u> - id AMP шаблона:<br>
```html
<link rel="amphtml" href="https://test.ru/test.html?amp">
<link rel="canonical" href="https://test.ru/test.html" />
```

Или если у вас несколько шаблонов, то к ссылке дописываем запрос `?amp=14` (14 - id шаблон):
```html
<link rel="amphtml" href="https://test.ru/test.html?amp=14">
<link rel="canonical" href="https://test.ru/test.html" />
```

**3.** В файле `robots.txt` разрешаем индексацию AMP-страниц:
```robots
Allow: *?amp
```


> Библиотека PHP - AMP PHP Library - [https://github.com/Lullabot/amp-library](https://github.com/Lullabot/amp-library)
