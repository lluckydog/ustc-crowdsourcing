package web

import (
	"fmt"
	"net/http"

	"Fabric/web/controllers"
)

// Serve starts
func Serve(app *controllers.Application) {
	mux := http.NewServeMux()

	mux.HandleFunc("/register", app.PostRegisterRequest)
	mux.HandleFunc("/login", app.PostLoginRequest)

	mux.HandleFunc("/queryuser", app.QueryUser)

	mux.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		http.Redirect(w, r, "/error", http.StatusTemporaryRedirect)
	})

	fmt.Println("Listening (http://localhost:3000/) ...")
	http.ListenAndServe(":3000", mux)
}
