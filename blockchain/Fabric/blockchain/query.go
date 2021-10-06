package blockchain

import (
	"fmt"

	"github.com/hyperledger/fabric-sdk-go/pkg/client/channel"
)

//QueryUser 查询用户信息
func (setup *FabricSetup) QueryUser() (string, error) {

	response, err := setup.client.Query(channel.Request{ChaincodeID: setup.ChainCodeID, Fcn: "QueryUser", Args: [][]byte{}})
	if err != nil {
		return "", fmt.Errorf("failed to query: %v", err)
	}
	return string(response.Payload), nil
}
