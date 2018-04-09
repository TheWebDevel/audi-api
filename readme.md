# Audi API

## Endpoints

----

### `GET /info`

Get basic version information of API.

`GET /info`

----

### `POST /auth/login`

User Login

`POST /auth/signup`

**Request Headers**

| Type | Requirement | Description |
|----|----|----|
| username | Required, string, exists:users,username | username of the user|
| user_password | Required, string | password of the user|

**Response Data**

| Parameter | Type | Description |
|----|----|----|
| user_auth_token | String | `Authentication token of the user|

----

### `POST /auth/cookie`

Validate stored token for auto-login.

`POST /auth/cookie`

**Request Headers**

| Type | Requirement | Description |
|----|----|----|
| id | Required, string, exists:users,id | user ID|
| user_auth_token | Required, string | Authentication token of the user|

**Response Data**

| Parameter | Type | Description |
|----|----|----|
| user_auth_token | String | `Authentication token of the user|

----

### `POST /book_audi`

Book auditoriums

`POST /book_audi`

**Request Headers**

| Type | Requirement | Description |
|----|----|----|
| audi_id | Required,exists:auditoriumss,id | Auditorium ID|
| title | Required, string | Event Title|
| description | string | Event Description |
| start_time | required, date | Event Start Time |
| end_time | required, date | Event End Time |

**Response Data**

| Parameter | Type | Description |
|----|----|----|
| Message | String | Confirmation Message|

----

### `POST /cancel_event/{id}`

Cancel a Booked Event

`POST /cancel_event/{id}`

**Request Headers**

| Type | Requirement | Description |
|----|----|----|
| id (From URL)| Required,exists:events,id | Event ID|
| password | Required, string | User Password|

**Response Data**

| Parameter | Type | Description |
|----|----|----|
| Message | String | Confirmation Message|

----

### `POST /timeline`

List of Future Events

`POST /timeline`

**Request Headers**

| Type | Requirement | Description |
|----|----|----|
| time| Required,date | Current time of the user|

**Response Data**

| Parameter | Type | Description |
|----|----|----|
| events | Array | List of future events|

----

### `GET /event_details/{id}`

Details of a specific event

`GET /event_details/{id}`

**Request Headers**

| Type | Requirement | Description |
|----|----|----|
| id (From URL)| Required,exists:events,id | Event ID|

**Response Data**

| Parameter | Type | Description |
|----|----|----|
| event | Object | Details of the event|

----
### `POST /change_password`

Change existing password

`POST /change_password`

**Request Headers**

| Type | Requirement | Description |
|----|----|----|
| old_password| Required,string | Old Password|
| new_password| Required,string| New Password |

**Response Data**

| Parameter | Type | Description |
|----|----|----|
| Message | String | Confirmation Message|

----











