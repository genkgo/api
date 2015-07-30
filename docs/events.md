Events
=====================
The following actions are available at the events site part.

| Command                            | Description                                    | Access level |
| :--------------------------------- |:---------------------------------------------- |:-------------|
| events                             | Returns all events                             | write        |
| 

## Events ##
Returns the list of all events

Parameters:

none

Returns:

- array of Events

### Example Post Values ###

Get all events.

| Key                                | Value                                          |
| :--------------------------------- |:---------------------------------------------- |
| entryToken                         | api token                                      |
| part                               | site                                           |
| command                            | model                                          |
| model                              | events                                         |
| action                             | events                                         |


## Event ##
Returns information about a specific event by it's ID

Parameters:

- id => ID of the target event

Returns:

- Events

### Example Post Values ###

Get information about event with ID 3.

| Key                                | Value                                          |
| :--------------------------------- |:---------------------------------------------- |
| entryToken                         | api token                                      |
| part                               | site                                           |
| command                            | model                                          |
| model                              | events                                         |
| action                             | event                                          |
| id                                 | 3                                              |

## Apply ##
Applies the user with the api key in entryToken for the given event

Parameters:

- id => ID of the target event

### Example Post Values ###

Apply the current user to the event with ID 3.

| Key                                | Value                                          |
| :--------------------------------- |:---------------------------------------------- |
| entryToken                         | api token                                      |
| part                               | site                                           |
| command                            | model                                          |
| model                              | events                                         |
| action                             | apply                                          |
| id                                 | 3                                              |

## Unapply ##
Unapplies the user with the api key in entryToken for the given event

Parameters:

- id => ID of the target event

### Example Post Values ###

Remove the current user from the event with ID 3.

| Key                                | Value                                          |
| :--------------------------------- |:---------------------------------------------- |
| entryToken                         | api token                                      |
| part                               | site                                           |
| command                            | model                                          |
| model                              | events                                         |
| action                             | unapply                                        |
| id                                 | 3                                              |


## Drop Applications ##
Unapplies all users who are currently applied for this event; remove all applications

Parameters:

- id => ID of the target event

### Example Post Values ###

Remove all users from the event with ID 3.

| Key                                | Value                                          |
| :--------------------------------- |:---------------------------------------------- |
| entryToken                         | api token                                      |
| part                               | site                                           |
| command                            | model                                          |
| model                              | events                                         |
| action                             | dropApplications                               |
| id                                 | 3                                              |

## Application List ##
 Get all user applications for a given event

Parameters:

- id => ID of the target event

Returns:

- array of OrganizationEntry's

### Example Post Values ###

Remove the current user from the event with ID 3.

| Key                                | Value                                          |
| :--------------------------------- |:---------------------------------------------- |
| entryToken                         | api token                                      |
| part                               | site                                           |
| command                            | model                                          |
| model                              | events                                         |
| action                             | applicationList                                |
| id                                 | 3                                              |
