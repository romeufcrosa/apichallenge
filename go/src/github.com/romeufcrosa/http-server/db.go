package main

import (
    "log"
    "database/sql"
    _ "github.com/go-sql-driver/mysql"
)

func read(env *Env, rowID int) {
    var (
        balanceID int
        customerID int
        websiteID int
        amount float32
        baseCurrencyCode []byte
    )
    rows, err := env.db.Query("SELECT * FROM enterprise_customerbalance WHERE customer_id = ?", rowID)
    if err != nil {
        log.Fatal(err)
    }
    defer rows.Close()
    for rows.Next() {
        err := rows.Scan(&balanceID, &customerID, &websiteID, &amount, &baseCurrencyCode)
        if err != nil {
            log.Fatal(err)
        }
        //log.Println(balanceID, customerID, amount)
    }
    err = rows.Err()
    if err != nil {
        log.Fatal(err)
    }
}

func create(name string) int64 {
    db, err := sql.Open("mysql",
        "user:password@tcp(127.0.0.1:3306)/test")
    err = db.Ping();
    if err != nil {
        log.Fatal(err)
    }
    defer db.Close()
    // Start Transaction
    tx, err := db.Begin()
    if err != nil {
        log.Fatal(err)
    }
    defer tx.Rollback()
    stmt, err := tx.Prepare("INSERT INTO users(name) VALUES(?)")
    if err != nil {
        log.Fatal(err)
    }
    defer stmt.Close()
    res, err := stmt.Exec(name)
    err = tx.Commit()
    if err != nil {
        log.Fatal(err)
    }
    lastID, err := res.LastInsertId()
    if err != nil {
        log.Fatal(err)
    }

    return lastID
}

func update(id int, name string) {
    db, err := sql.Open("mysql",
        "user:password@tcp(127.0.0.1:3306)/test")
    err = db.Ping();
    if err != nil {
        log.Fatal(err)
    }
    defer db.Close()
    // Start Transaction
    tx, err := db.Begin()
    if err != nil {
        log.Fatal(err)
    }
    defer tx.Rollback()
    stmt, err := tx.Prepare("UPDATE users SET name = ? WHERE id = ?")
    if err != nil {
        log.Fatal(err)
    }
    defer stmt.Close()
    _, err = stmt.Exec(name, id)
    if err != nil {
        log.Fatal(err)
    }
    err = tx.Commit()
    if err != nil {
        log.Fatal(err)
    }
}

func delete(id int) {
    db, err := sql.Open("mysql",
        "user:password@tcp(127.0.0.1:3306)/test")
    err = db.Ping();
    if err != nil {
        log.Fatal(err)
    }
    defer db.Close()
}
