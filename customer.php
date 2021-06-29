<?php
//include auth_session.php file on all user panel pages
include("partials/auth_session.php");
if ($_SESSION['role'] != 'customer') {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>User page</title>
	<script src='js/web3.min.js'></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script type="text/javascript" src="js/grid.js"></script>
	<script type="text/javascript" src="js/version.js"></script>
	<script type="text/javascript" src="js/detector.js"></script>
	<script type="text/javascript" src="js/formatinf.js"></script>
	<script type="text/javascript" src="js/errorlevel.js"></script>
	<script type="text/javascript" src="js/bitmat.js"></script>
	<script type="text/javascript" src="js/datablock.js"></script>
	<script type="text/javascript" src="js/bmparser.js"></script>
	<script type="text/javascript" src="js/datamask.js"></script>
	<script type="text/javascript" src="js/rsdecoder.js"></script>
	<script type="text/javascript" src="js/gf256poly.js"></script>
	<script type="text/javascript" src="js/gf256.js"></script>
	<script type="text/javascript" src="js/decoder.js"></script>
	<script type="text/javascript" src="js/qrcode.js"></script>
	<script type="text/javascript" src="js/findpat.js"></script>
	<script type="text/javascript" src="js/alignpat.js"></script>
	<script type="text/javascript" src="js/databr.js"></script>
	<link rel="stylesheet" href="css/style2.css" />
	<style>
		.qrbutton,
		#action {
			width: 250px !important;
			font-size: small !important;
			background-color: lightgray;
			color: black;
			border-color: lightgray;
		}
	</style>
</head>

<body>
	<div class="logo">
		<div>
			<table style="width: 100%;">
				<tr>
					<td style="font-size:20px;font-family:forte;">
						<font color="#428bca">
							<p>Hey, <?php echo $_SESSION['username']; ?>!</p>
						</font>
					</td>
					<td> <br> <br>
						<font size="4px">
							<a href="">Track medicine authenticity</a>
						</font>
					</td>
					<td style="text-align: right;"> <br> <br>
						<font size="4px">
							<a href="logout.php">LOGOUT</a>
						</font>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<br><br><br><br>
	<div class="content">
		<div>
			<center>
				<form id="form1" autocomplete="off" onsubmit="return getHistory(form1)">
					<input type="text" id="medid" placeholder="Enter Product Code">
					<br><br><br>
					<button type="submit" id="searchButton">Get History</button>
				</form>
				<br><br>or<br><br>
				<input type=file accept="image/*" id="selectedFile" onchange="encodeImageFileAsURL(this)" style="display:none">
				<button class="qrbutton" onclick="document.getElementById('selectedFile').click();">
					Input QR image file
				</button>
				<!--<button id="action">Done</button>-->
			</center>
		</div>
	</div>
	<br><br>
	<center>
		<div id="view">
			<p id="v2"></p>
			<p id="v3"></p>
			<p id="v4"></p>
			<p id="v5"></p>
			<p id="v6"></p>
			<p id="v7"></p>
			<p id="v8"></p>
			<p id="v9"></p>
		</div>
		<div id="tracked">
			<p id="t1"></p>
			<p id="t2"></p>
			<p id="t3"></p>
			<p id="t4"></p>
			<p id="t5"></p>
			<p id="t6"></p>
		</div>
	</center>
	<br><br><br>

	<script>
		async function connectWallet() {
			if (window.ethereum) {
				window.web3 = new Web3(window.ethereum);
			}

			conn = await window.ethereum.enable();

			ethconnected = conn.length > 0
			if (ethconnected) {
				ethaddress = conn[0] // get wallet address
			}
			web3.eth.getAccounts().then(console.log);

			return true;
		}
		connectWallet();
		/*if (typeof web3 !== 'undefined') {
			web3 = new Web3(web3.currentProvider);
		} else {
			// set the provider you want from Web3.providers
			web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
		}
		web3.eth.defaultAccount = web3.eth.accounts[0];*/

		var scaddress = '0x0bd41f508cFC6782C5430AC68Af10f64aD8c0b1b';
		var contract = new web3.eth.Contract([{
				"inputs": [{
						"internalType": "uint256",
						"name": "_upc",
						"type": "uint256"
					},
					{
						"internalType": "string",
						"name": "_loctime",
						"type": "string"
					}
				],
				"name": "setBought",
				"outputs": [],
				"stateMutability": "nonpayable",
				"type": "function"
			},
			{
				"inputs": [{
						"internalType": "uint256",
						"name": "_upc",
						"type": "uint256"
					},
					{
						"internalType": "string",
						"name": "_loctime",
						"type": "string"
					}
				],
				"name": "setMade",
				"outputs": [],
				"stateMutability": "nonpayable",
				"type": "function"
			},
			{
				"inputs": [{
						"internalType": "uint256",
						"name": "_upc",
						"type": "uint256"
					},
					{
						"internalType": "string",
						"name": "_manfid",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "_distid",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "_phid",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "_facname",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "_latitude",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "_longitude",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "_medname",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "_medprice",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "_qty",
						"type": "string"
					}
				],
				"name": "setMed",
				"outputs": [],
				"stateMutability": "nonpayable",
				"type": "function"
			},
			{
				"inputs": [{
						"internalType": "uint256",
						"name": "_cnt",
						"type": "uint256"
					},
					{
						"internalType": "string",
						"name": "_newqty",
						"type": "string"
					}
				],
				"name": "setMedQtyCount",
				"outputs": [],
				"stateMutability": "nonpayable",
				"type": "function"
			},
			{
				"inputs": [{
						"internalType": "uint256",
						"name": "_upc",
						"type": "uint256"
					},
					{
						"internalType": "string",
						"name": "_loctime",
						"type": "string"
					}
				],
				"name": "setPacked",
				"outputs": [],
				"stateMutability": "nonpayable",
				"type": "function"
			},
			{
				"inputs": [{
						"internalType": "uint256",
						"name": "_upc",
						"type": "uint256"
					},
					{
						"internalType": "string",
						"name": "_loctime",
						"type": "string"
					}
				],
				"name": "setReceived",
				"outputs": [],
				"stateMutability": "nonpayable",
				"type": "function"
			},
			{
				"inputs": [{
						"internalType": "uint256",
						"name": "_upc",
						"type": "uint256"
					},
					{
						"internalType": "string",
						"name": "_loctime",
						"type": "string"
					}
				],
				"name": "setShipped",
				"outputs": [],
				"stateMutability": "nonpayable",
				"type": "function"
			},
			{
				"inputs": [{
						"internalType": "uint256",
						"name": "_upc",
						"type": "uint256"
					},
					{
						"internalType": "string",
						"name": "_loctime",
						"type": "string"
					}
				],
				"name": "setSold",
				"outputs": [],
				"stateMutability": "nonpayable",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getBoughtLoc",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getDistId",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getFacName",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getLatitude",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getLongitude",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getMadeLoc",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getManfId",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getMedName",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getMedPrice",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getPackedLoc",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getPhId",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getQty",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getReceivedLoc",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getShippedLoc",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "_upc",
					"type": "uint256"
				}],
				"name": "getSoldLoc",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [],
				"name": "getUpc",
				"outputs": [{
					"internalType": "uint256",
					"name": "",
					"type": "uint256"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "",
					"type": "uint256"
				}],
				"name": "history",
				"outputs": [{
						"internalType": "string",
						"name": "madeloc",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "packedloc",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "soldloc",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "boughtloc",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "shippedloc",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "receivedloc",
						"type": "string"
					}
				],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [],
				"name": "medcount",
				"outputs": [{
					"internalType": "uint256",
					"name": "",
					"type": "uint256"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "",
					"type": "uint256"
				}],
				"name": "medicines",
				"outputs": [{
						"internalType": "uint256",
						"name": "medno",
						"type": "uint256"
					},
					{
						"internalType": "uint256",
						"name": "upc",
						"type": "uint256"
					},
					{
						"internalType": "string",
						"name": "manfid",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "distid",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "phid",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "facname",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "latitude",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "longitude",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "medname",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "medprice",
						"type": "string"
					},
					{
						"internalType": "string",
						"name": "qty",
						"type": "string"
					}
				],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "",
					"type": "uint256"
				}],
				"name": "mednameByNo",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "",
					"type": "uint256"
				}],
				"name": "medqtyByNo",
				"outputs": [{
					"internalType": "string",
					"name": "",
					"type": "string"
				}],
				"stateMutability": "view",
				"type": "function"
			},
			{
				"inputs": [{
					"internalType": "uint256",
					"name": "",
					"type": "uint256"
				}],
				"name": "medstates",
				"outputs": [{
						"internalType": "bool",
						"name": "made",
						"type": "bool"
					},
					{
						"internalType": "bool",
						"name": "packed",
						"type": "bool"
					},
					{
						"internalType": "bool",
						"name": "sold",
						"type": "bool"
					},
					{
						"internalType": "bool",
						"name": "bought",
						"type": "bool"
					},
					{
						"internalType": "bool",
						"name": "shipped",
						"type": "bool"
					},
					{
						"internalType": "bool",
						"name": "received",
						"type": "bool"
					}
				],
				"stateMutability": "view",
				"type": "function"
			}
		], scaddress);

		console.log(contract);

		var curupc = 1;

		contract.methods.getUpc().call().then(function(upc) {
			console.log(upc);
		})

		function encodeImageFileAsURL(element) {
			var file = element.files[0];
			var reader = new FileReader();
			reader.onloadend = function() {
				var imageURI = reader.result;
				console.log('RESULT', reader.result);
				decodeImageFromBase64(imageURI, function(decodedInformation) {
					document.getElementById("medid").value = decodedInformation;
				});
			}
			reader.readAsDataURL(file);
		}

		/**
		 * The function decodeImageFromBase64 expects as first parameter a base64 string from a QRCode.
		 * As second parameter the callback that expects the data from the QRCode as first parameter.
		 */
		function decodeImageFromBase64(data, callback) {
			// set callback
			qrcode.callback = callback;
			// Start decoding
			qrcode.decode(data)
		}

		// On button click, decode the qrCode from the base64 format.
		/*document.getElementById("action").addEventListener('click', function() {
			decodeImageFromBase64(imageURI, function(decodedInformation) {
				document.getElementById("medid").value = decodedInformation;
			});
		}, false);*/


		function getHistory() {

			curupc = document.getElementById("medid").value;

			contract.methods.getQty(curupc).call().then(function(hist) {
				if (hist.length == 0) {
					window.location.reload();
					alert("This medicine is not registered by manufacturer!");
				}
			}).then(function(h) {
				contract.methods.getMadeLoc(curupc).call().then(function(hist) {
					document.getElementById("t1").innerHTML = "Made: " + hist;
					console.log(hist);
				})
				contract.methods.getPackedLoc(curupc).call().then(function(hist) {
					console.log(hist);
					document.getElementById("t2").innerHTML = "Packed: " + hist;
				})
				contract.methods.getSoldLoc(curupc).call().then(function(hist) {
					console.log(hist);
					document.getElementById("t3").innerHTML = "Sold: " + hist;
				})
				contract.methods.getBoughtLoc(curupc).call().then(function(hist) {
					console.log(hist);
					document.getElementById("t4").innerHTML = "Bought: " + hist;
				})
				contract.methods.getShippedLoc(curupc).call().then(function(hist) {
					console.log(hist);
					document.getElementById("t5").innerHTML = "Shipped: " + hist;
				})
				contract.methods.getReceivedLoc(curupc).call().then(function(hist) {
					console.log(hist);
					document.getElementById("t6").innerHTML = "Received: " + hist;
				})

				contract.methods.getManfId(curupc).call().then(function(meddata) {
					console.log(meddata);
					document.getElementById("v2").innerHTML = "Manufacturer Id: " + meddata;
				})
				contract.methods.getDistId(curupc).call().then(function(meddata) {
					console.log(meddata);
					document.getElementById("v3").innerHTML = "Distributor Id: " + meddata;
				})
				contract.methods.getPhId(curupc).call().then(function(meddata) {
					console.log(meddata);
					document.getElementById("v4").innerHTML = "Pharmacist Id: " + meddata;
				})
				contract.methods.getFacName(curupc).call().then(function(meddata) {
					console.log(meddata);
					document.getElementById("v5").innerHTML = "Factory name: " + meddata;
				})
				contract.methods.getLatitude(curupc).call().then(function(meddata) {
					console.log(meddata);
					document.getElementById("v6").innerHTML = "Factory Latitude: " + meddata;
				})
				contract.methods.getLongitude(curupc).call().then(function(meddata) {
					console.log(meddata);
					document.getElementById("v7").innerHTML = "Factory Longitude: " + meddata;
				})
				contract.methods.getMedName(curupc).call().then(function(meddata) {
					console.log(meddata);
					document.getElementById("v8").innerHTML = "Medicine Name: " + meddata;
				})
				contract.methods.getMedPrice(curupc).call().then(function(meddata) {
					console.log(meddata);
					document.getElementById("v9").innerHTML = "Medicine Price: " + meddata;
				})
			})

			return (false);
		}
	</script>

</body>

</html>