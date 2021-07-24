## Настройка

* Создать `.env` из `.env.template`
* Установить зависимости через контейнер php `composer install`
* Запустить в контейнере php команду `php artisan key:generate`
* Ниже в документации можно увидеть конструкции типа `${SOMETHIG}` - где `SOMETHING` переменная из `.env`
* Накатить миграции с фикстурами `php artisan migrate:fresh --seed`
* Запустить `make all` в контейнере с php.
* В отдельных окнах в контейнере с php:
  `php artisan queue:work --queue=achievements`
  `php artisan queue:work --queue=experience`

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

* Получить агрегацию баллов по времени


```

{
    taskResultsByTimeAggregation(user_id: 1, date_from: "2020-01-01") {
        user {
          name
        },
        skill {
          name
        },
        total_assessment
    }
}

date_from - Дата в формате Y-m-d.

```

* Получить агрегацию по курсам и модулям по root-нодам

```
{
taskResultExerciseGroup{
  id
  name
  calculate_assessments
}
}
```

* Получить агрегацию по курсам и модулям

```
{
taskResultExerciseGroup(id: 3){
  id
  name
  calculate_assessments
}
}
```

* Получить агрегацию баллов по заданиям, занятиям и по навыкам (все):

```
{
  TaskExerciseSkillAggregations {
  
    exercise {
      id
      name
    }
    task {
      id
      title
      description
    }
    skill {
	  id
      code
      name
    }
    total_experience
  }
}

```

* Получить агрегацию баллов по заданиям, занятиям и по навыкам (по конкретному task_id):

```
{
  TaskExerciseSkillAggregation (task_id:30) {
  
    exercise {
      id
      name
    }
    task {
      id
      title
      description
    }
    skill {
	  id
      code
      name
    }
    total_experience
  }
}

```
