# API Challenge

### What is this?
The idea is to collectively pool our coding resources in order to achieve the best performing API in whatever language you prefer.
They will all run through a performance benchmarker and the results will be published.

### API Definition
To maintain consistency (and fairness) here is the spec for the API
  - REST
  - Have 1 controller/router that takes GET requests on /whatever/:id
  - Link that to a whatever model that queries a database and returns the row as a JSON payload to the requester.
  - Query => SELECT * FROM table WHERE customer_id = :id

### Database Definition
This is to emulate a customer credit table, if you want to have the same data structure as I have on the testbed I'm publishing a SQL file with the table creation.

### Constraints
Again to maintain fairness in the results some changes need to be explicitly declared and replicated across all APIs.

For example, in the current GO API I use github.com/go-sql-driver/mysql as the MySQL driver. If you have a better performing driver then by all means use it, I call this a **soft constraint**, meaning there is no need to change all drivers for other APIs. Same goes for other libs/extensions/drivers.

However if you decide to use a different DB Engine (i.e. MariaDB, MongoDB, Postgres, etc) then this is a **hard constraint**. All other APIs need to be changed to use the same DB Engine.


### Performance Benchmarking
To make it easy to do this please either make your APIs boostrapped like the ones already commited.
If you really want to use nginx, apache2, etc. Then please also post your server conf file including vhosts. So that it can be easily replicated in the testbed.

**!Warning!** Also, if you do any system tweaking (i.e. increasing the file limits in /etc/security/limits.conf) please document these changes as well.


### Folder Structure

I decided to create a base folder structure per language, this was just for convenience so feel free to submit code however you prefer.

### What's included?

I've started the ball rolling by developing 3 APIs, in no way are these the best possible... that's the whole point of this, to improve and provide alternatives.
So feel free to change my code however you like. Or create your new API from scratch.

Everytime there's a commited change I'll re-run the testbed and publish the benchmarks as *commit hash*.bench so that it can be easily traced to specific code changes.

I recommend providing a README file for every new API created detailing the fundamentals (some of this stuff mentioned before) like the versions of everything used.
I'll document below and example for the 3 APIs included.

## PHP API - ReactPHP

### _Running the App
Dependencies are taken care by Composer, so just have it installed and run ``composer install`` in the folder.

To start the API server just do
``php run-server.php ``

### _Tech Used
* [ReactPHP] - v0.4.1
* [PIMF]     - v1.9
* [PHP-PDO]  - v5.5.9 tied to the PHP Version

## NodeJS API

### _Running the App
Dependencies are taken care by npm, so just have it installed and run ``npm install`` in the folder.

To start the API server just do
``node server.js ``

### _Tech Used
* [node.js]     - v4.4.4
* [Express]     - v4.0.0
* [mysql]       - v2.11.1
* [body-parser] - v1.0.1


## Golang API
### _Running the App
See packages used below and install them

To start the API server just do
``./bin/http-server ``
This is a Linux compiled binary, so for Mac/Windows you will need to recompile it.

### _Tech Used
* [golang]          - v1.2.4
* [go-sql-driver]   - v1.2.0

___
# Final Thoughts
That's pretty much it, so commit code, open pull requests, fork stuff. Whatever you want. Whenever something is commited I'll run the testbed ASAP and publish the results. Enjoy.

# 1st Run Benchmarks
As a curiosity here are the performance results for the 3 current APIs as of the initial commit.
>Note: ReactPHP ran on 500 rps (requests per second) because that's the "optimal" threshold it could handle. I suspect this could be improved with some tweaks on php.ini but I didn't want to do this because I see it as external interference on the test results.

### *ReactPHP*
```
$ loadtest http://localhost:8080/credits/21 -t 20 -c 20 --rps 500
[Mon Jun 27 2016 11:49:33 GMT+0100 (WEST)] INFO Requests: 0, requests per second: 0, mean latency: 0 ms
[Mon Jun 27 2016 11:49:38 GMT+0100 (WEST)] INFO Requests: 2237, requests per second: 447, mean latency: 0 ms
[Mon Jun 27 2016 11:49:43 GMT+0100 (WEST)] INFO Requests: 4736, requests per second: 500, mean latency: 10 ms
[Mon Jun 27 2016 11:49:48 GMT+0100 (WEST)] INFO Requests: 7236, requests per second: 500, mean latency: 0 ms
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO Target URL:          http://localhost:8080/credits/21
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO Max time (s):        20
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO Concurrency level:   20
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO Agent:               none
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO Requests per second: 500
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO Completed requests:  9732
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO Total errors:        0
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO Total time:          20.001337132 s
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO Requests per second: 487
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO Total time:          20.001337132 s
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO Percentage of the requests served within a certain time
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO   50%      3 ms
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO   90%      6 ms
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO   95%      8 ms
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO   99%      16 ms
[Mon Jun 27 2016 11:49:53 GMT+0100 (WEST)] INFO  100%      1004 ms (longest request)
```
___
### *NodeJS*
```
$ loadtest http://localhost:9000/api/credit/21 -t 20 -c 20 --rps 1000
[Tue Jun 28 2016 17:18:19 GMT+0100 (WEST)] INFO Requests: 0, requests per second: 0, mean latency: 0 ms
[Tue Jun 28 2016 17:18:24 GMT+0100 (WEST)] INFO Requests: 4493, requests per second: 899, mean latency: 10 ms
[Tue Jun 28 2016 17:18:29 GMT+0100 (WEST)] INFO Requests: 9480, requests per second: 998, mean latency: 0 ms
[Tue Jun 28 2016 17:18:34 GMT+0100 (WEST)] INFO Requests: 14493, requests per second: 1003, mean latency: 0 ms
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO Target URL:          http://localhost:9000/api/credit/21
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO Max time (s):        20
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO Concurrency level:   20
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO Agent:               none
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO Requests per second: 1000
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO Completed requests:  19492
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO Total errors:        0
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO Total time:          20.002571341 s
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO Requests per second: 974
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO Total time:          20.002571341 s
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO Percentage of the requests served within a certain time
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO   50%      2 ms
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO   90%      4 ms
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO   95%      7 ms
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO   99%      57 ms
[Tue Jun 28 2016 17:18:39 GMT+0100 (WEST)] INFO  100%      170 ms (longest request)
```
___
### *Golang*
```
$ loadtest http://localhost:8080/credits/21 -t 20 -c 20 --rps 1000
[Tue Jun 28 2016 17:02:54 GMT+0100 (WEST)] INFO Requests: 0, requests per second: 0, mean latency: 0 ms
[Tue Jun 28 2016 17:02:59 GMT+0100 (WEST)] INFO Requests: 4426, requests per second: 885, mean latency: 30 ms
[Tue Jun 28 2016 17:03:04 GMT+0100 (WEST)] INFO Requests: 9422, requests per second: 1000, mean latency: 0 ms
[Tue Jun 28 2016 17:03:09 GMT+0100 (WEST)] INFO Requests: 14423, requests per second: 1000, mean latency: 0 ms
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO Target URL:          http://localhost:8080/credits/21
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO Max time (s):        20
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO Concurrency level:   20
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO Agent:               none
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO Requests per second: 1000
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO Completed requests:  19417
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO Total errors:        0
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO Total time:          20.001395778 s
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO Requests per second: 971
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO Total time:          20.001395778 s
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO Percentage of the requests served within a certain time
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO   50%      2 ms
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO   90%      4 ms
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO   95%      6 ms
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO   99%      54 ms
[Tue Jun 28 2016 17:03:14 GMT+0100 (WEST)] INFO  100%      1416 ms (longest request)
```

[PIMF]: <http://gjerokrsteski.github.io/pimf-framework/>
[ReactPHP]: <http://reactphp.org/>
[PHP-PDO]: <http://php.net/manual/en/ref.pdo-mysql.php>
[mysql]: <https://www.npmjs.com/package/mysql>
[body-parser]: <https://www.npmjs.com/package/body-parser>
[golang]: <https://golang.org/>
[go-sql-driver]: <https://godoc.org/github.com/go-sql-driver/mysql>
[node.js]: <http://nodejs.org>
[express]: <http://expressjs.com>
[AngularJS]: <http://angularjs.org>
