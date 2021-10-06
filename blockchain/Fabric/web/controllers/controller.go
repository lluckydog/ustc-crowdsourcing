package controllers

import (
	"io"
	"net/http"

	"Fabric/blockchain"
)

//Application represents that
type Application struct {
	Fabric *blockchain.FabricSetup
}

func (app *Application) PostRegisterRequest(w http.ResponseWriter, r *http.Request) {
	userName := r.PostFormValue("username")
	userRole := r.PostFormValue("userrole")
	schoolid := r.PostFormValue("schoolid")
	if userName == "" || userRole == "" || schoolid == "" {
		if userName == "" {
			io.WriteString(w, "username is empty!")
		}
		if userRole == "" {
			io.WriteString(w, "userrole is empty!")
		}
		if schoolid == "" {
			io.WriteString(w, "schoolid is empty!")
		}
	} else {
		success := true
		err := app.Fabric.RegisterUser(userName)
		if err != nil {
			success = false
		}
		err = app.Fabric.UserLogin(userName)
		if err != nil {
			success = false
		}
		_, err = app.Fabric.InvokeCreateUser(userRole, schoolid)
		if err != nil {
			success = false
		}
		if success {
			io.WriteString(w, "注册成功")
		} else {
			io.WriteString(w, "注册失败")
		}
	}
}
func (app *Application) PostLoginRequest(w http.ResponseWriter, r *http.Request) {
	userName := r.PostFormValue("username")
	err := app.Fabric.UserLogin(userName)
	if err == nil {
		io.WriteString(w, "登陆成功")
	} else {
		io.WriteString(w, "登陆失败")
	}

}
func (app *Application) PostTask(w http.ResponseWriter, r *http.Request) {
	taskName := r.PostFormValue("taskname")
	duration := r.PostFormValue("duration")
	startTime := r.PostFormValue("starttime")
	taskBrif := r.PostFormValue("taskbrif")
	exceptedPrice := r.PostFormValue("exceptedprice")
	_, err := app.Fabric.InvokePostTask(taskName, duration, startTime, taskBrif, exceptedPrice)
	if err == nil {
		io.WriteString(w, "发布成功")
	} else {
		io.WriteString(w, "发布失败")
	}

}
func (app *Application) QueryUser(w http.ResponseWriter, r *http.Request) {
	data, _ := app.Fabric.QueryUser()
	io.WriteString(w, data)
}
