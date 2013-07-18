<?php
$waluta = $currencies->currencies[$currency]['symbol_right'];
?>

<script type="text/javascript" language="javascript">
function FormatNumber(num)
{
	if(isNaN(num)) { num = "0"; }
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10) { cents = "0" + cents; }
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	{
		num = num.substring(0,num.length-(4*i+3))+'.'+ num.substring(num.length-(4*i+3));
	}
	return (((sign)?'':'-') + num + ',' + cents);
}

function showPrice(form)
{
	var myTotalPrice = 0;
	var showUP = 0;
    var myPrice = 0;
	var myMathProblem = "";
	var myWaluta = 0;
	var myItemPrice = parseFloat(form.nuPrice.value);
	var myStawkaVat = parseFloat(form.vat_stawka.value);
	for (var i = 0; i < form.elements.length; i++)
	{
		var e = form.elements[i];
		if ( e.type == 'select-one' )
		{
			showUP = 1;
			Item = e.selectedIndex;
			myPrice = e.options[Item].text;
	    } else if (e.type == 'radio' && e.checked) {
	      showUP = 1;
	      myPrice = e.getAttribute('price');
	    } else {showUP = 0}

    if (showUP == 1) {
			var myDollarSign = myPrice.indexOf("(",0)
			if ( myDollarSign != "-1" )
			{
				myParSign = myPrice.indexOf(")", myDollarSign);
				myWaluta = myPrice.indexOf(" ", myDollarSign);
				myAttributeString = myPrice.substring(myWaluta + 1, myParSign);
				tysiac = myAttributeString.lastIndexOf(",");
				if ( tysiac != "-1" ) {
					myAttributeString = myAttributeString.replace(".","");
				}
				myAttributeString = myAttributeString.replace(/,/,".");
				myAttributePrice = parseFloat(myAttributeString);
				myMathProblem = myPrice.charAt(myDollarSign + 1);
			} else { myAttributePrice = 0; }
			if (myMathProblem == "-")
			{
				myTotalPrice = myTotalPrice - myAttributePrice;
			} else {
				myTotalPrice = myTotalPrice + myAttributePrice;
			}
		}
	}
	myStawkaVat = (myStawkaVat/100)+1;
	myTotalPrice_Netto = FormatNumber((myTotalPrice + myItemPrice)/myStawkaVat)
	myTotalPrice = FormatNumber(myTotalPrice + myItemPrice);
	<?php
	if (DISPLAY_PRICE_BRUTTO_NETTO == 'true') {
	    echo 'document.getElementById("nowaCena").innerHTML = myTotalPrice_Netto + "' . ' '. $waluta .'<span class=\'smallText\'>'.TEXT_NETTO . '</span><br>" + myTotalPrice + " '. $waluta .'<span class=\'smallText\'>' . TEXT_BRUTTO . '</span>";';
	  } else {
	    echo 'document.getElementById("nowaCena").innerHTML = myTotalPrice+ "' . ' '. $waluta . '";';
    }
	?>
}
</script>