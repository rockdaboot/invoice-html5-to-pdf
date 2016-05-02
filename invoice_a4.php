<?php

class item {
	public $name;
	public $description;
	public $units;
	public $unitprice;

	public function __construct(Array $value = array()) {
		$this->name = $value[0];
		$this->description = $value[1];
		$this->units = $value[2];
		$this->unitprice = $value[3];
	}
}

function de_float($number) {
	return number_format($number, 2, ',', '.');
}

function currency($number) {
	return de_float($number) . " €";
}

require 'config.php';
require 'receiver.php';

/*
$orderDate = "03/2016";
$orderId = "RE/190416/1";

// Leistungsempfänger
$receiver_company = "Muster GmbH";
$receiver_name = "Max Mustermann";
$receiver_street = "Musterstraße 55";
$receiver_postal = "20123 Musterstadt";
$receiver_country = "";
$receiver_custid = 100;

// Rechnungspositionen
$items = array(
	new item(array("Outbound","Nutzung pro Minute ausgehend",753.6,0.02)),
	new item(array("IVR","IVR Dienste pro Minute eingehend",75.57,0.03)),
	new item(array("Intro","Nutzung pro Minute eingehend",14.06,0.03)),
	new item(array("Passiv","Passiv Nutzung pro Minute eingehend",3421.43,0.05)),
	new item(array("Chat","Tarif 29ct",4723,0.29)),
	new item(array("Chat","Tarif 32ct",3940.12,0.32)),
);
*/


$price = 0;
$subTotalPrice = 0;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Invoice Template</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		page { size:A4; margin-left:auto; margin-right:auto; }
		html { height:100%; }
		body { margin-left:2.2cm; margin-right:1cm; }
		table { border-collapse:collapse; border-spacing:0; border:0; width:100%; }
		th, td { padding:0; }
		@media print { footer {page-break-after:always; } }

		.foldmark { position:absolute; background-color:black; height:1px; width:3mm; left:4mm; }
	</style>
</head>
<body>
<div class="foldmark" style="top:35.35%;"></div>
<div class="foldmark" style="top:70.70%;"></div>
<div style="width:100%; height:5.1cm; background:url(<?php echo $logoImage ?>) right center no-repeat;"></div>
<div style="font-size:100%; font-family:Helvetica, sans-serif; float:left; width:100%;">
	<table>
	<tr>
		<td><span style="width:70%; font-size:65%; text-decoration:underline;"><?php
			echo $sender_company . " · ";
			echo $sender_street . " · ";
			echo $sender_zip . " " . $sender_city;
			echo "</span><br><br>";
			echo $receiver_company ? "<strong>" . $receiver_company . "</strong><br>" : "";
			echo $receiver_name ? $receiver_name . "<br>" : "";
			echo $receiver_street ? $receiver_street . "<br><br>" : "<br>";
			echo $receiver_postal ? $receiver_postal . "<br>" : "";
			echo $receiver_country ? $receiver_country . "<br>" : "<br>";
			?>
			<br><br><br><br><br>
		</td>
		<td style="width:30%; vertical-align:top;">
			<?php
			echo "<strong>" . $sender_company . "</strong><br>";
			echo $sender_street . "<br>";
			echo $sender_zip . " " . $sender_city . "<br>";
			?>
			<br>
			<table>
				<?php echo "<tr><td><strong>fon</strong></td><td>" . $sender_fon . "</td></tr>"; ?>
				<?php echo "<tr><td><strong>fax</strong></td><td>" . $sender_fax . "</td></tr>"; ?>
				<?php echo "<tr><td><strong>eml</strong></td><td>" . $sender_eml . "</td></tr>"; ?>
				<?php echo "<tr><td><strong>www</strong></td><td>" . $sender_www . "</td></tr>"; ?>
			</table>
		</td>
	</tr>
	</table>

	<table>
	<tr>
		<td style="font-size: 100%; font-weight: bold;">
			<?php echo "Rechnung " . $orderId; ?>
		</td>
		<td style="text-align:right; font-size: 90%;">
			<?php echo $sender_city . ", den " . date("d.m.Y"); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="border-bottom: 1px solid #000;">
			<br>
			KundenNr.: <?php echo $receiver_custid; ?><br>
			Zeitraum: <?php echo $orderDate; ?><br>
			<br><br>
		</td>
	</tr>
	</table>

	<table>
	<tr style="font-weight: bold;">
		<td style="width:15%;">Artikel</td>
		<td style="width:45%;">Beschreibung</td>
		<td style="width:10%; text-align:right;">Menge</td>
		<td style="width:15%; text-align:right;">Einzelpreis</td>
		<td style="width:15%; text-align:right;">Preis</td>
	</tr>
	<tr>
		<td colspan="5" style="border-top:1px solid #000;">&nbsp;</td>
	</tr>

	<?php foreach( $items as $item ):
		$price = $item->units * $item->unitprice;
		$subTotalPrice = $subTotalPrice + $price;
	?>
	<tr>
		<td><?php echo $item->name; ?></td>
		<td><?php echo $item->description; ?></td>
		<td style="text-align:right;"><?php echo de_float($item->units); ?></td>
		<td style="text-align:right;"><?php echo currency($item->unitprice); ?></td>
		<td style="text-align:right;"><?php echo currency($price); ?></td>
	</tr>
	<?php endforeach; ?>

	<tr>
		<td colspan="5" style="border-bottom:1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" style="text-align:right;">Nettobetrag</td>
		<td style="text-align:right;"><?php echo currency($subTotalPrice); ?></td>
	</tr>
	<tr>
		<td colspan="4" style="text-align:right;">Umsatzsteuer <?php echo $tax . "%";?></td>
		<td style="text-align:right;"><?php echo currency($subTotalPrice * $tax / 100); ?></td>
	</tr>
	<tr>
		<td colspan="5" style="border-bottom: 1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" style="text-align:right; font-weight:bold;">Rechnungsbetrag</td>
		<td style="text-align:right; font-weight:bold;"><?php echo currency(round($subTotalPrice,2) + round($subTotalPrice * $tax / 100,2)); ?></td>
	</tr>
	</table>

	<br><br><br>

	<table>
	<tr>
		<td style="font-weight:bold;"><u>Hinweise</u></td>
	</tr>
	<tr>
		<td>
			<br>
			Der Rechnungsbetrag ist zahlbar innerhalb 14 Tagen ohne Abzug.<br>
			Irrtum und Änderungen vorbehalten. Es gelten unsere AGB.<br><br><br>
			Vielen Dank für Ihren Auftrag.
		</td>
	</tr>
	</table>

	<footer style="position:fixed; bottom:5mm; left:0; font-size: 70%; font-weight: bold; text-align: center; width: 100%; vertical-align:bottom;">
		<?php echo $sender_footer; ?>
	</footer>
</div>
</body>
</html>
