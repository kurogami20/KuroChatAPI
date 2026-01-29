# Routes

A description of all the routes of the API

## User

| Method | Endpoint            | Description    | Access |
| ------ | ------------------- | -------------- | ------ |
| POST   | /api/v1/user/login  | Connect a user | public |
| POST   | /api/v1/user/signin | Create a user  | public |
| POST   | /api/v1/user/logout | Connect a user | auth   |

## Conversations

| Method | Endpoint                 | Description             | Access |
| ------ | ------------------------ | ----------------------- | ------ |
| GET    | /api/v1/conversation     | List all conversations  | auth   |
| GET    | /api/v1/conversation/:id | List one conversation   | auth   |
| POST   | /api/v1/conversation     | create one conversation | auth   |
| DELETE | /api/v1/conversation     | Delete a conversation   | auth   |

## Question

| Method | Endpoint         | Description       | Access |
| ------ | ---------------- | ----------------- | ------ |
| POST   | /api/v1/question | Create a question | auth   |

## Reponse

| Method | Endpoint        | Description      | Access |
| ------ | --------------- | ---------------- | ------ |
| POST   | /api/v1/reponse | Create a reponse | auth   |
