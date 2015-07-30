Organization
=====================

The organization part supports the following commands.

| Command                            | Description                                    | Access level |
| :--------------------------------- |:---------------------------------------------- |:-------------|
| [tree](#tree)                      | get the folder from the organization tree      | read         |
| [find](#find)                      | find the first child matched by name           | read         |
| [query](#query)                    | find all descendants by name and/or uid        | read         |
| [move](#move)                      | move an entry in the tree                      | delete       |
| [delete](#delete)                  | remove an entry from the system (no way back)  | delete       |
| [modify](#modify)                  | modify information from an entry               | write        |
| [alias](#alias)                    | create an alias from an entry                  | write        |
| [group](#group)                    | add an entry to a group                        | write        |
| [objectclass](#objectclass)        | get information from an entry                  | read         |
| [login](#login)                    | verify login credentials                       | read         |
| [create](#create)                  | create a new entry                             | write        |
| [search](#search)                  | advanced search                                | read         |
| [objectclasses](#objectclasses)    | see objectclass, this command returns multiple | read         |
| [entry](#entry)                    | get tree information for this entry            | read         |
| [wall](#wall)                      | get the wall of this entry                     | write        |

## Tree ##
 Get the folder from the organization tree

Parameters:

- id => the id of the parent element

Returns:

- array of organizationalUnits (folders)


## Find ##
Find the first child matched by name

Parameters:

- id => the id of the parent element
- name => the exact name of the element to find 

Returns:

- entry


## Query ##
Find all descendants by name and/or uid

Parameters:

- id => the id of the parent element
- q => the string that will match to the entry's name or uid
- optional limit
- optional offset

Returns:

- array of entries


## Move ##
Move an entry in the tree

Parameters:

- id => the id of the source element
- target => the id of the entry that it will be moved to

Returns:

- string: true/false


## Delete ##
Remove an entry from the system (no way back)

Parameters:

- id => the id of the parent element
- target => the id of the entry that will be removed

Returns:

- string: true/false


## Alias ##
Create an alias from an entry

Parameters:

- id => the id of the parent element
- target => the id of the entry that the entry will be moved to

Returns:

- string: true/false


## Group ##
Add an entry to a group

Parameters:

- id => the id of the element to add to the group
- target => the id of the group entry

Returns:

- string: true/false


## Objectclass ##
Get information from an entry

Parameters:

- id => the id of the element to add to the group
- tab => the name of the tab to get information from

Returns:

- mixed (depending on tab)


## Login ##
Verify login credentials

Parameters:

- uid => username
- password => password
- returnType => boolean|entry default: boolean

Returns:

- mixed (depending on return type)


## Create ##
Create a new entry

Parameters:

- id => the id of the parent element 
- name => name of the new element
- objectclass => objectclass (string) of the new element genkgoPerson|organization|group|organizationalRole etc.

Returns:

- entry object


## Entry ##
Get tree information for this entry

Parameters:

- id => the id of the element 

Returns:

- entry object
- 


## Wall (read) ##
Get wall posts for this entry

Parameters:

- id => the id of the entry
- optional type => the type of wallposts (default on log)

Returns:

- list of messages

## Wall (write) ##
Write a wall post from sender to recipients

Parameters:

- sender => the id of the sender entry
- type => The type of wallpost. Most common are public, private and log.
- recipients => array of the id's of the sender entries
- message => The message to be send

Returns:
- the send message
