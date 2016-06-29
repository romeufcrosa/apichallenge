package main

import (
    "encoding/json"
    "io/ioutil"
    "log"
    "fmt"
    "net/http"
    //"net/url"
    "strconv"
)

type postStruct struct {
    Name string
}

func userHandler(w http.ResponseWriter, r *http.Request) {
    fmt.Println(r.Method)
    switch r.Method {
        case "GET":
            // Serve the resource
            userID, err := strconv.Atoi(r.URL.Path[len("/credits/"):])
            if err != nil {
                log.Fatal(err)
            }
            //fmt.Printf("Retrieving info for user = %d\n", userID)
            read(userID)
        case "POST":
            // Create a new record
            var p postStruct
            decoder := json.NewDecoder(r.Body)
            err := decoder.Decode(&p)
            if err != nil {
                log.Fatal(err)
            }
            createdID := create(p.Name)
            log.Printf("Inserted row ID = %d", createdID)
        case "PUT":
            // Update an existing record
            var f interface{}
            body, _ := ioutil.ReadAll(r.Body)
            err := json.Unmarshal(body, &f)
            if err != nil {
                log.Fatal(err)
            }
            m := f.(map[string]interface{})
            var newName = m["name"].(string)
            var updatedID = int(m["id"].(float64))
            read(updatedID)
            update(updatedID, newName)
            read(updatedID)
        case "DELETE":
            // Remove the record
        default:
            // Show error
    }
}

func main() {
    http.HandleFunc("/credits/", userHandler)
    http.ListenAndServe(":8080", nil)
}
