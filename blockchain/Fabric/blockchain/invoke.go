package blockchain

import (
	"fmt"
	"time"

	"github.com/hyperledger/fabric-sdk-go/pkg/client/channel"
)

// InvokeCreateUser 调用链码函数CreateUser
func (setup *FabricSetup) InvokeCreateUser(userRole string, schoolId string) (string, error) {

	eventID := "eventInvokeCreateUser"

	reg, notifier, err := setup.event.RegisterChaincodeEvent(setup.ChainCodeID, eventID)
	if err != nil {
		return "", err
	}
	defer setup.event.Unregister(reg)

	response, err := setup.client.Execute(channel.Request{ChaincodeID: setup.ChainCodeID, Fcn: "CreateUser", Args: [][]byte{[]byte(userRole, schoolId)}})

	if err != nil {
		return "", fmt.Errorf("failed to move funds: %v", err)
	}
	select {
	case ccEvent := <-notifier:
		fmt.Printf("Received CC event: %v\n", ccEvent)
	case <-time.After(time.Second * 20):
		return "", fmt.Errorf("did NOT receive CC event for eventId(%s)", eventID)
	}

	return string(response.Payload), nil
}
