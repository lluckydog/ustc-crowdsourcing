package main

import (
	"fmt"

	"github.com/hyperledger/fabric/core/chaincode/shim"
	pb "github.com/hyperledger/fabric/protos/peer"
)

type Chaincode struct {
}

//初始化链码
func (t *Chaincode) Init(stub shim.ChaincodeStubInterface) pb.Response {
	return shim.Success(nil)
}

//链码调用
func (t *Chaincode) Invoke(stub shim.ChaincodeStubInterface) pb.Response {
	function, args := stub.GetFunctionAndParameters()
	if function == "CreateUser" { //创建用户
		return t.CreateUser(stub, args)
	} else if function == "QueryUser" { //查询用户
		return t.QueryUser(stub, args)
	}
	return shim.Error("Received unknown function invocation")
}

func main() {
	err := shim.Start(new(Chaincode))
	if err != nil {
		fmt.Printf("Error starting Trade chaincode: %s ", err)
	}
}
