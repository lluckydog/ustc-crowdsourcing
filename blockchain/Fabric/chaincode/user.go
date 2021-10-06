package main

import (
	"encoding/json"

	"github.com/hyperledger/fabric/core/chaincode/shim"
)

//用户信息
type User struct {
	UserID   string `json:UserID`   //用户ID
	SchoolId int    `json:SchoolId` //学校ID
	UserRole string `json:UserRole` //用户身份
}

//IsUserExist 判断用户是否存在
func (t *Chaincode) IsUserExist(stub shim.ChaincodeStubInterface, userName string) bool {
	userJSONBytes, err := stub.GetState(userName)
	return err != nil || userJSONBytes != nil
}

//IsAdmin 判断用户是否为admin
func (t *Chaincode) IsAdmin(stub shim.ChaincodeStubInterface, uname string) bool {
	userJSONBytes, err := stub.GetState(uname)
	if err != nil {
		return false
	}
	user := User{}
	err = json.Unmarshal(userJSONBytes, &user)
	if err != nil {
		return false
	}
	return user.UserRole == "admin"
}

//UserGetter 通过用户名返回用户信息的结构体
func (t *Chaincode) UserGetter(stub shim.ChaincodeStubInterface, userName string) (User, error) {
	userJSONBytes, err := stub.GetState(userName)
	user := User{}
	if err != nil {
		return user, err
	}
	err = json.Unmarshal(userJSONBytes, &user)
	if err != nil {
		return user, err
	}
	return user, nil
}

//UserSetter 将用户信息存入区块链中
func (t *Chaincode) UserSetter(stub shim.ChaincodeStubInterface, user User) error {
	userJSONBytes, err := json.Marshal(user)
	if err != nil {
		return err
	}
	err = stub.PutState(user.UserID, userJSONBytes)
	return err
}
