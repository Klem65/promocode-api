# Проект Promocode-api

## Установка

### 1. Клонировать репозиторий

```bash
git clone git@github.com:Klem65/promocode-api.git
cd promocode-api
```

### 2. Запустить контейнеры Docker

```bash
docker-compose up -d
```

### 3. Установить зависимости PHP

```bash
docker-compose exec php bash
composer install
```

### 4. Выполнить миграции базы данных

```bash
./yii migrate
```

## Тестирование

### Добавление admin пользователя
Создаем первого пользователя
```bash
./yii create-user/add admin
```
Пример ответа:
```bash
User 'admin' has been added.
Token: 'EpTHgINhRzty94hNb0YIxUesLh4LKrHQ'.
```

Далее полученный токен вставляем в header authorization : Bearer + {token}

## Использование API

### Импорт Postman коллекции
Импортируйте файл Promocode.postman_collection.json в Postman для доступа к предопределённым запросам.

### Создание пользователя
```bash
curl --location 'http://localhost:8080/api/user/create' \
--header 'Authorization: Bearer EpTHgINhRzty94hNb0YIxUesLh4LKrHQ' \
--header 'Content-Type: text/plain' \
--data '{
    "username": "user_example"
}'
```
Ответ: 
```json
{
    "success": true,
    "username": "user_example",
    "token": "_bpgAqhAtHoGDoVcNcOHG4Ql3XUiQJu0"
}
```
### Получение промокода по токену
```bash
curl --location 'http://localhost:8080/api/promocode/show' \
--header 'Authorization: Bearer _bpgAqhAtHoGDoVcNcOHG4Ql3XUiQJu0' \
--data ''
```
Ответ 
```json
{
    "success": true,
    "user_id": 12,
    "user_name": "user_example",
    "code": "CRSKC"
}
```
---