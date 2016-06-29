package main

import (
    //"encoding/json"
    //"io/ioutil"
    "log"
    "fmt"
    "net/http"
    //"net/url"
    "strconv"
)

func creditHandler(w http.ResponseWriter, r *http.Request) {
    fmt.Println(r.Method)
    switch r.Method {
        case "GET":
            // Serve the resource
            creditID, err := strconv.Atoi(r.URL.Path[len("/credits/"):])
            if err != nil {
                log.Fatal(err)
            }
            read(creditID)
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
    http.HandleFunc("/credits/", creditHandler)
    http.ListenAndServe(":8080", nil)
}
