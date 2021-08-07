# Примечание

> Проект реализованный во время прохождения курса `PHP Developer. Professional` на [OTUS](https://otus.ru/)
> В текущий момент ведутся доработки проекта

## Доработать

* Graphql агрегации
* Кеш

## Настройка

* Создать `.env` из `.env.template`
* Запустить докер
* Ниже в документации можно увидеть конструкции типа `${SOMETHIG}` - где `SOMETHING` переменная из `.env`
* Накатить миграции с данными `php artisan migrate:fresh --seed`

## Команды

> Запускаются при запуске докера, но можно запустить руками в контейнере `php`, если что-то пошло не так

* `composer install` - Composer зависимости
* `php artisan key:generate` - Генерация и установка APP_KEY
* `make all` - Создаёт exchange и очереди
* `php artisan queue:work --queue=achievements` - Запускает consumer для очереди ачивок
* `php artisan queue:work --queue=experience` - Запускает consumer для очереди расчёта опыта

## Swagger

* Команда для генерации свагера - `php artisan l5-swagger:generate`
* Адрес документации свагера - `/api/documentation`

## Grafana

* Адрес: `${INTERFACE}:${GRAFANA_PORT}`
* Настроенные дашборды:
    * `Application` - данные из приложения, которые достаются из prometheus
* Другие дашборды взяты из примера и будет разобраны\доработаны

## Prometheus

* Адрес: `${INTERFACE}:${PROMETHEUS_PORT}`
* Адрес с таргетами: `${INTERFACE}:${PROMETHEUS_PORT}/targets`
* Адрес для сбора метрик приложения `${INTERFACE}/metrics`
* [Библиотека для работы](https://github.com/Superbalist/laravel-prometheus-exporter)
* Метрики:
    * `app_request_count` - количество запросов.
    * `app_response_time_seconds` - длительность запроса

## GraphQL

* Адрес: `${INTERFACE}/graphiql`
* [Библиотека для работы](https://github.com/rebing/graphql-laravel)

