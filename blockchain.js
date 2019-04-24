const _TOKEN_ADDRESS = '0x654899645B3638E63A37CB21Ff7B312f6ae77DB5'; // HDC Contract address
let _WALLET_ADDRESS = document.querySelector('#main-wallet .wallet').value;
let _RECIPIENTS_ADDRESS = document.querySelector('#vendor-wallet .wallet').value;
let _TOKEN_DECIMALS;

let _DETAILS = {
    tokenAddress: _TOKEN_ADDRESS,
    tokenDecimals: _TOKEN_DECIMALS,
    walletAddress: {
        main: _WALLET_ADDRESS,
        vendor: _RECIPIENTS_ADDRESS
    }
}

function getERC20TokenBalance(tokenAddress, walletAddress, callback) {
    let minABI = [
        // balanceOf
        {
            'constant': true,
            'inputs': [
                {
                    'name': '_owner',
                    'type': 'address'
                }
            ],
            'name': 'balanceOf',
            'outputs': [
                {
                    'name': 'balance',
                    'type': 'uint256'
                }
            ],
            'type': 'function'
        },
        // decimals
        {
            'constant': true,
            'inputs': [],
            'name': 'decimals',
            'outputs': [
                {
                    'name': '',
                    'type': 'uint8'
                }
            ],
            'type': 'function'
        }
    ];

    let contract = web3.eth.contract(minABI).at(tokenAddress);
    contract.balanceOf(walletAddress, (error, balance) => {
        contract.decimals((error, decimals) => {
            balance = balance.div(10 ** decimals);
            console.log('Got balance:', balance.toString());
            callback(balance);
        });
    });
}

function getERC20TokenContract(tokenAddress) {
    let minABI = [
        {'constant':true,'inputs':[{'name':'_owner','type':'address'}],'name':'balanceOf','outputs':[{'name':'balance','type':'uint256'}],'type':'function'},
        {'constant':true,'inputs':[],'name':'decimals','outputs':[{'name':'','type':'uint8'}],'type':'function'},
        {'constant':false,'inputs':[{'name':'_to','type':'address'},{'name':'_value','type':'uint256'}],'name':'transfer','outputs':[{'name':'','type':'bool'}],'type':'function'}
    ];
    console.log('Contract details:', web3.eth.contract(minABI).at(tokenAddress))
    return web3.eth.contract(minABI).at(tokenAddress);
}

function getERC20TokenDecimals(callback) {
    window.tokenContract.decimals((error, decimals) => {
        console.log('Got decimals:', decimals);
        callback(decimals);
    });
}

function getHDCBalance(e) {
    _WALLET_ADDRESS = document.querySelector('#main-wallet .wallet').value;
    _RECIPIENTS_ADDRESS = document.querySelector('#vendor-wallet .wallet').value;
    if (_WALLET_ADDRESS && _RECIPIENTS_ADDRESS) {
        getERC20TokenBalance(_TOKEN_ADDRESS, _WALLET_ADDRESS, balance => {
            document.querySelector('#main-wallet .balance').innerText = balance.toString();
        });
        getERC20TokenBalance(_TOKEN_ADDRESS, _RECIPIENTS_ADDRESS, balance => {
            document.querySelector('#vendor-wallet .balance').innerText = balance.toString();
        });

        window.tokenContract = getERC20TokenContract(_TOKEN_ADDRESS);
        getERC20TokenDecimals(decimals => {
            console.log('Got token decimals:', decimals)
            _TOKEN_DECIMALS = decimals;
        });
    }
}

function transferERC20Token(toAddress, value, callback) {
    window.tokenContract.transfer(toAddress, value, (error, txHash) => {
        callback(txHash);
    });
}

function sendHDC(val) {
    let toAddress = _RECIPIENTS_ADDRESS;
    let decimals = _TOKEN_DECIMALS;
    let amount = web3.toBigNumber(val)
    let sendValue = amount.times(web3.toBigNumber(10).pow(decimals));
    console.log(sendValue.toString());
    transferERC20Token(toAddress, sendValue, txHash => {
        if (txHash) {
            let content = `<a href="https://ropsten.etherscan.io/tx/${txHash}" target="_blank">Transaction</a>`
            document.getElementById('result').innerHTML = content;
        }
    });
    // return false;
}

window.onload = function () {
    if (typeof web3 !== 'undefined') {
        web3 = new Web3(web3.currentProvider);
    } else {
        web3 = new Web3(new Web3.providers.HttpProvider('https://mainnet.infura.io'));
    }
    console.log('Web3.js version:', web3.version);
    getHDCBalance();
};
