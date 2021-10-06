package main

import (
	"strconv"

	"github.com/hyperledger/fabric/core/chaincode/shim"
	pb "github.com/hyperledger/fabric/protos/peer"
)

//CreateUser 用于存储用户信息
func (t *Chaincode) CreateUser(stub shim.ChaincodeStubInterface, args []string) pb.Response {
	//args参数为用户角色
	if len(args) != 2 {
		return shim.Error("The number of args must be 2!")
	}
	//用户必须为poster或worker
	if args[0] != "admin" && args[0] != "user" {
		return shim.Error("The role must be admin or user!")
	}
	//获取调用者用户名
	uname, err := t.GetUserName(stub)
	if err != nil {
		return shim.Error(err.Error())
	}
	//判断用户是否已存在
	if t.IsUserExist(stub, uname) {
		return shim.Error("UserID already exist!")
	}
	//判断第二个参数是否为数字
	schoolid, err := strconv.Atoi(args[1])
	if err != nil {
		return shim.Error("UserID already exist!")
	}
	// TODO schoold判断
	user := User{UserID: uname, UserRole: args[0], SchoolId: schoolid}
	//将用户信息存储到区块中
	err = t.UserSetter(stub, user)
	if err != nil {
		return shim.Error(err.Error())
	}
	err = stub.SetEvent("eventInvokeCreateUser", []byte{}) //Notify listeners that an event "eventInvoke" have been executed
	if err != nil {
		return shim.Error(err.Error())
	}
	return shim.Success(nil)
}
