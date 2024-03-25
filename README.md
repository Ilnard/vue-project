# Версии приложения

**1.2.0 - Добавление "Организация" и "Добавить сотрудника"

* В базе данных добавлена таблица members
* На сервере добавлен API для получения данных о сотрудниках и для добавления сотрудника в базу данных
* Добавлена страница "Добавить сотрудника" с валидацией и отправкой данных на сервер
* Добавлена страница "Организация" с наполнением данных из сервера
* Переписан generalStore, удален orderStore (всё сделано под один store)

* Переписан код сервера (использование классов)
* Небольшие исправления в клиенте

**1.0.1 - Рефакторинг сервера

* Переписан код сервера (использование классов)
* Небольшие исправления в клиенте

**1.0.0 - Первая версия

* Реализация отображения заказов
* Реализация формы добавления заказа