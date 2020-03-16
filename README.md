# REST API using Slim Framework 3

### Description
This project follow [DDD](https://en.wikipedia.org/wiki/Domain-driven_design) approach. It is maintainable and we can write our tests easily.

I have used [Slim Framework](https://www.slimframework.com/) in this example.

#### Pre-requisites
PHP, mysql and composer installed. 

#### Dependencies
* Slim Framework
* Doctrine ORM
* Monolog
* PHP-View

#### Tools used:

- PHPStorm Editor
- Mysql WorkBench
- Git
- Postman

#### Installation
```
git clone https://github.com/rajsquid/restest.git
cd restest
```
Install Dependencies
```
composer install
```
Database Schema Screenshot can be found - `/etc/restapidb.png`

Run the below command in console

```
mysql -u <username> -p <database name> < /path/to/etc/restestapi.sql
```

Change the MySql connection string in `config/application.development.ini` and `application.test.ini`


Then start the project
```
composer start
```

#### Domain details

- A user has a name and email and associated with a role(Admin/User)  .
- A contract has a name and associated with a risk level(Low/medium/high)
- A user can manage one or many contracts.
- A contract can have three states.(Processing/Reviewing/Approved)
- An assignment/workflow can have entity types like a)A Contract which is assigned to a user b)User details c)What state the contract is going through

### Folder structure -

### Application

It is a way of communicating with the outside world (outside the domain). This layer behaves like an open API for our application.
`Presentations` is used to choose the content type you need to return. Here JSON is used.

##### GET reserved keyword

There is a reserved keyword `fields` is used  GET parameters to filter the properties the user needs.
Example :
```bash
http://localhost:8080/user?fields=id
-->
[{"id":2},{"id":3},{"id":4}]

http://localhost:8080/user?fields=id,name
-->
[{"id":2,"name":"User2"},{"id":3,"name":"User3"},{"id":4,"name":"User4"}
```

If no field is specified, all default properties are returned.

### Domain

This is where the business rules and logic resides, the domain models are defined etc.

### Infrastructure

The mapping between entities and ORM are in 
`Infrastructure/Repository/Doctrine/Mapping`. This layer supports a structure of interactions between other layers. Hence the repositories are in this folder.

## Tests

```
composer test
composer test-application
composer test-domain
composer test-infrastructure
``` 

### Further investigation

- While I was trying to insert two foreign keys in a table, the slim was accepting the first one. So I had to write 
a custom insert query.I will see if this can be done without using custom query.


### Next Steps(ToDo)
- [ ] Create DELETE method for a User and write test.
- [ ] Write tests for Process class
- [ ] Create new class for User-Review-Assignment relationship and write test
- [ ] Add database migration
- [ ] Implement secured authentication in middleware.
- [ ] Add Doctrine Second Level Cache
- [ ] Upgrade Slim to version 4
- [ ] Update README.md after all todos with further improvements