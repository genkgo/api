Photoalbum
=====================
The following actions are available at the photoalbum site part.

| Command                            | Description                                    | Access level |
| :--------------------------------- |:---------------------------------------------- |:-------------|
| [albums](#albums)                  | return the list of available photoalbums       | write        |
| [pictures](pictures)               | get all pictures in an album                   | write        |
| [picture](#picture)               | get the raw data of a given picture            | write        |

## Albums ##
Returns the list of available photoalbums

Parameters:

- albumId => the id of the parent photoalbum where to look for subalbums (optional)
- limit => the amount of items to be retrieved (optional; default on 20)
- offset => the item to start retrieving (optional; default on 0)

Returns:

- items => array of Photoalbums
- count => number of retrievable items

### Example Post Values ###

Get all "root" photoalbums.

| Key                                | Value                                          |
| :--------------------------------- |:---------------------------------------------- |
| entryToken                         | api token                                      |
| part                               | site                                           |
| command                            | model                                          |
| model                              | photoalbum                                     |
| action                             | albums                                         |

Get 2 of the subalbums of photoalbum with id 3.

| Key                                | Value                                          |
| :--------------------------------- |:---------------------------------------------- |
| entryToken                         | api token                                      |
| part                               | site                                           |
| command                            | model                                          |
| model                              | albums                                         |
| model                              | photoalbum                                     |
| action                             | albums                                         |
| albumId                            | 3                                              |
| limit                              | 2                                              |

## Pictures ##
Returns a list of all pictures in a specific photoalbum

Parameters:

- albumId => the id of the photoalbum in which to look for pictures
- limit => the amount of items to be retrieved (optional; default on 100)
- offset => the item to start retrieving (optional; default on 0)

Returns:

- items => array of picture names
- count => number of retrievable items

### Example Post Values ###

Get all "root" pictures in photoalbum with id 3.

| Key                                | Value                                          |
| :--------------------------------- |:---------------------------------------------- |
| entryToken                              | api token                                      |
| part                               | site                                           |
| command                            | model                                          |
| model                              | photoalbum                                     |
| action                             | pictures                                       |
| albumId                            | 3                                              |

## Picture ##
 Returns raw data of a given picture

Parameters:

- albumId => the id of the photoalbum in which to look for the given picture
- photoName => the photo_name as given by the pictures api action

Returns:

- raw data of the given picture in full size

### Example Post Values ###

Get all "root" pictures in photoalbum with id 3.

| Key                                | Value                                          |
| :--------------------------------- |:---------------------------------------------- |
| entryToken                              | api token                                      |
| part                               | site                                           |
| command                            | model                                          |
| model                              | photoalbum                                     |
| action                             | picture                                        |
| albumId                            | 3                                              |
| ohitiName                          | sample_picture.jpg                            |
