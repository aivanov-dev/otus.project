## Настройка

* Создать `.env` из `.env.template`
* Установить зависимости через контейнер php `composer install`
* Запустить в контейнере php команду `php artisan key:generate`
* Ниже в документации можно увидеть конструкции типа `${SOMETHIG}` - где `SOMETHING` переменная из `.env`

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

### Примеры:

* Задача с влияниями и навыками:

```
{
  task(id: 1) {
    id
    influences {
      value
      id
      skill {
        name
        code
      }
    }
  }
}

```

* Влияние с задачей и навыком

```
{
  influence(id: 1) {
    value
    task {
      title
      description
    }
    skill {
      name
    }
  }
}
```

* Все навыки, их влияния и задачи

```
{
  skills{
    name,
    influences{
      task{
        title
      }
    }
  }
}
```
