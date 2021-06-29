<?php
//include auth_session.php file on all user panel pages
include("partials/auth_session.php");
if ($_SESSION['role'] != 'manufacturer') {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Manufacturer page</title>
	<script src='js/web3.min.js'></script>
	<script src="js/qrcodegenerator.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<link rel="stylesheet" href="css/style2.css" />
	<style>
		#addButton,
		#generateBtn {
			width: 280px !important;
			font-size: small !important;
			background-color: lightgray;
			color: black;
			border-color: lightgray;
		}

		.downloadBtn {
			background: none;
			border: none;
			color: #809180;
			font-weight: 600;
			letter-spacing: 1px;
			cursor: pointer;
			padding: 2px;
		}

		.downloadBtn:hover {
			border-bottom: dashed #809180 2px;
		}

		.hide {
			display: none;
		}

		.qrdiv {
			text-align: center;
		}

		.qrcode {
			margin: 30px 0;
		}

		canvas {
			display: none;
		}

		.qrcode>img {
			background-color: #fff;
		}

		#made,
		#packed,
		#forSale {
			width: 240px !important;
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
							<a href="">Add medicine details</a>
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
	<div class="content">
		<br><br><br>
		<center>
			<div class="qrdiv"></div>
			<div class="qrcode"></div>
			<form id="form1" onsubmit="return addMed(form1)">
				<input type="text" id="upc" placeholder="Enter UPC(Universal Product code)"><br><br>
				<input type="text" id="mid" placeholder="Enter Manufacturer id"><br><br>
				<input type="hidden" id="did" value="234A2145">
				<input type="hidden" id="pid" value="347N1187">
				<input type="text" id="fname" placeholder="Enter Factory name"><br><br>
				<input type="text" id="latitude" placeholder="Enter Factory latitude"><br><br>
				<input type="text" id="longitude" placeholder="Enter Factory longitude"><br><br>
				<input type="text" id="mname" placeholder="Enter Medicine name"><br><br>
				<input type="text" id="mprice" placeholder="Enter Medicine price"><br><br>
				<input type="text" id="qty" placeholder="Enter quantity"><br><br>
				<button onclick="addMed()" type="submit" id="addButton">Submit</button>
			</form>
			<br><br>
			<div class="main" id="main">

				<button class="btn" id="generateBtn">Generate QR code</button>
				<div class="qrdiv hide" id="qrdiv">
					<div class="qrcode" id="qrcode"></div>
					<!--<button class="downloadBtn" id="downloadBtn">Download</button>-->
				</div>
			</div>
			<br><br>
			<button onclick="changeMade()" id="made">Made</button><br><span id="m"></span><br><br>
			<button onclick="changePacked()" id="packed">Packed</button><br><span id="p"></span><br><br>
			<button onclick="changeSold()" id="forSale">For Sale</button><br><span id="s"></span><br><br><br>
			<button onclick="track()" id="track">Track medicine</button>
		</center>
	</div>
	<br><br><br>
	<center>
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
		function main() {
			const generateBtn = document.getElementById("generateBtn");
			const dataBox = document.getElementById("upc");
			const downloadBtn = document.getElementById("downloadBtn");
			const qrcode = document.getElementById("qrcode");
			const qrdiv = document.getElementById("qrdiv");

			const errorClassName = "error";
			const shakeClassName = "shake";
			const dataBoxClassName = "dataBox";
			const toHideClassName = "hide";
			const qrdivClassName = "qrdiv";

			var QR_CODE = new QRCode("qrcode", {
				width: 160,
				height: 160,
				colorDark: "#000000",
				colorLight: "#ffffff",
				correctLevel: QRCode.CorrectLevel.H,
			});

			generateBtn.onclick = function(e) {
				const data = dataBox.value;
				if (data) {
					generateQRCode(data);
				} else {
					markDataBoxError();
				}
			};

			dataBox.onfocus = function(e) {
				const classList = dataBox.classList;

				if (classList.contains(errorClassName)) {
					// Removing error class
					dataBox.className = dataBoxClassName;
				}
			};

			downloadBtn.onclick = function(e) {
				// Image tag
				const img = qrcode.getElementsByTagName("img")[0];
				// Canvas tag
				const canvas = qrcode.getElementsByTagName("canvas")[0];

				// Padding to QRCode
				const padding = 40;

				// Adding padding to width and height
				canvas.width = canvas.width + padding;
				canvas.height = canvas.height + padding;

				// Canvas context
				const context = canvas.getContext("2d");
				// Clearing previous content
				context.clearRect(0, 0, canvas.width, canvas.height);
				// Making the background white
				context.fillStyle = "#ffffff";
				context.fillRect(0, 0, canvas.width, canvas.height);
				// Adding the image of QRCode
				// x and y are padding / 2
				context.drawImage(img, padding / 2, padding / 2);

				// Getting base64 url
				const image = canvas.toDataURL("image/png", 1);
				const filename = "QR_Code_" + Date.now() + ".png";
				downloadImage(image, filename);
			};

			function markDataBoxError() {
				const prevClassName = dataBox.className;
				dataBox.className =
					prevClassName + " " + errorClassName + " " + shakeClassName;
				vibrate();
				setTimeout(() => {
					// Reset class
					dataBox.className = prevClassName + " " + errorClassName;
				}, 500);
			}

			function generateQRCode(data) {
				QR_CODE.clear();
				QR_CODE.makeCode(data);
				// Show QRCode div
				qrdiv.className = qrdivClassName;
			}

			function vibrate() {
				if (Boolean(window.navigator.vibrate)) {
					window.navigator.vibrate([100, 100, 100]);
				}
			}

			function downloadImage(image, filename) {
				// Creating hidden <a> tag to download
				var element = document.createElement("a");
				element.setAttribute("href", image);
				element.setAttribute("download", filename);
				element.setAttribute("class", toHideClassName);
				document.body.appendChild(element);
				element.click();
				document.body.removeChild(element);
			}
		}

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
			curupc = upc;
			console.log(curupc);
		})


		function addMed() {
			var upc = document.getElementById("upc").value;
			curupc = upc;
			var mid = document.getElementById("mid").value;
			var did = document.getElementById("did").value;
			var pid = document.getElementById("pid").value;
			var fname = document.getElementById("fname").value;
			var latitude = document.getElementById("latitude").value;
			var longitude = document.getElementById("longitude").value;
			var mname = document.getElementById("mname").value;
			var mprice = document.getElementById("mprice").value;
			var qty = document.getElementById("qty").value;

			contract.methods.setMed(upc, mid, did, pid, fname, latitude, longitude, mname, mprice, qty).send({
				from: ethaddress
			}, async function(error, transactonHash) {
				console.log(transactonHash);
			}).then(function(h) {
				main();
			})
			return (false);
		}

		function changeMade() {

			var loc = new Date() + " Hyderabad ";
			contract.methods.setMade(curupc, loc).send({
				from: ethaddress
			}, async function(error, transactonHash) {
				console.log(transactonHash);
			})
			document.getElementById("m").innerHTML = "Manufactured!";
		}

		function changePacked() {

			console.log(curupc);
			var loc = new Date() + " Hyderabad ";
			contract.methods.setPacked(curupc, loc).send({
				from: ethaddress
			}, async function(error, transactonHash) {
				console.log(transactonHash);
			})
			document.getElementById("p").innerHTML = "Packaging done!";
		}

		function changeSold() {

			var loc = new Date() + " Hyderabad ";
			contract.methods.setSold(curupc, loc).send({
				from: ethaddress
			}, async function(error, transactonHash) {
				console.log(transactonHash);
			})
			document.getElementById("s").innerHTML = "Kept for sale!";
		}

		function track() {

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

		}
	</script>
</body>

</html>