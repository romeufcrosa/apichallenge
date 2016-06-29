package main

import (
    //"encoding/json"
    //"io/ioutil"
    "log"
    "net/http"
    "database/sql"
    "strconv"
)

type Env struct {
    db *sql.DB
}

func (env *Env) creditHandler(w http.ResponseWriter, r *http.Request) {
    switch r.Method {
        case "GET":
            // Serve the resource
            creditID, err := strconv.Atoi(r.URL.Path[9:])
            if err != nil {
                log.Fatal(err)
            }
            read(env, creditID)
        case "POST":
            // Create a new record
        case "PUT":
            // Update an existing record
        case "DELETE":
            // Remove the record
        default:
            // Show error
    }
}

func main() {
// START UP DB
    db, err := sql.Open("mysql",
        "root:my-secret-pw@tcp(127.0.0.1:3306)/test")

    if err != nil {
        log.Fatal(err)
    }

    env := &Env{db: db}

    http.DefaultTransport.(*http.Transport).MaxIdleConnsPerHost = 100
    http.HandleFunc("/credits/", env.creditHandler)
    http.ListenAndServe(":8080", nil)
}
