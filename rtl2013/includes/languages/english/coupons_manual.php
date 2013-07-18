<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Jak korzystać z modułu kuponów rabatowych</title>
<style type="text/css">
<!--
.tableBorder {
	border: 1px solid #333333;
}
body {
	font-family: Tahoma, "Trebuchet MS", Verdana, Arial, sans-serif;
	font-size: 10pt;
}
.code {
	font-family: "Courier New", Courier, mono;
	font-size: 10pt;
}
h3 {
	font-family: Tahoma, "Trebuchet MS", Verdana, Arial, sans-serif;
	font-size: 14pt;
	font-weight: bolder;
	font-variant: normal;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #333333;
	border-left-width: 10px;
	border-left-style: solid;
	border-left-color: #333333;
	padding-left: 10px;
	margin-top: 50px;
}
h2 {
	font-family: Tahoma, "Trebuchet MS", Verdana, Arial, sans-serif;
	font-size: 16pt;
	font-weight: bolder;
	color: #99CCCC;
	background-color: #333333;
	text-align: center;
	padding: 5px;
}
h4 {
	font-family: Tahoma, "Trebuchet MS", Verdana, Arial, sans-serif;
	font-size: 14pt;
	font-weight: bolder;
	font-style: italic;
}
li {
	margin-bottom: 10px;
}
.notice {
	background-color: #BFDFFF;
	padding: 2px;
	border: 1px solid #666666;
	margin: 20px;
	width: 95%;
}
-->
</style>
</head>

<body>
<h2>Jak korzystać z modułu kuponów rabatowych</h2>
<h3>Zawartość:</h3>
<ul>
  <li><a href="#configure">Konfiguracja modułu kuponów rabatowych</a></li>
  <li><a href="#creating">Tworzenie kuponów rabatowych</a>
    <ul>
      <li><a href="#fields">Opis pól kuponu rabatowego</a>
      </li>
    </ul>
  </li>
  <ul>
    <li> <a href="#percentage_discounts">Jak utworzyć rabat procentowy</a></li>
    <li><a href="#fixed_discounts"> Jak utworzyć rabat kwotowy</a></li>
  </ul>
</ul>
<h3><a name="configure"></a>Konfigurowanie modułu kuponów rabatowych</h3>
 <p>Aby skonfigurować w sklepie moduł kuponów rabatowych należy w panelu administracyjnym wybrać menu <strong>Moduły
   &gt; Suma zamówienia &gt; Kupon rabatowy</strong>. Następnie wybieramy przycisk <strong>Edycja</strong> w celu skonfigurowania ustawień modułu. Poniżej znajduje się opis poszczególnych pól:</p>
 <ul><li><strong>Kupony rabatowe</strong>     <br>
    Czy wyświetlać kupony rabatowe ? Włączenie modułu spowoduje wyświetlanie dodatkowego pola na wprowadzenie kodu rabatowego podczas wyboru sposobu płatności.</li>
   <li><strong>Kolejność wyświetlania</strong>     <br>
     Kolejność w jakiej zostanie wyświetlony rabat wynikający z kuponu rabatowego. Wartość jest wyświetlana we wszelkich podsumowaniach zamówienia.</li>
   <li><strong>Wyświetlaj rabat ze znakiem minus (-)</strong>     <br>
     Opcja ta umożiwia włączenie lub wyłączenie wyświetlania znaku minus (-) przy rabacie. Informacja ta jest wyświetlana na podsumowaniu zamówienia, mailach do użytkowników, itp.</li>
   <li><strong>Pokaż podsumę z rabatem</strong>     <br>
     Włączenie tej opcji powoduje, że podsuma w zamówieniu będzie uwzględniała udzielony rabat Po włączeniu tej opcji należy pamiętać, aby kolejność wyświetlania modulu kuponów rabatowych w podsumowaniu zamówienia była przed podsumą zamówienia.<br>
     Na przykład:
       <br>
       <table border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder">
         <tr>
           <td align="right">zakupiony przedmiot x 1:&nbsp;&nbsp;&nbsp;</td>
           <td>25.00 PLN</td>
         </tr>
         <tr>
           <td align="right">Kupon rabatowy nr XYZ:&nbsp;&nbsp;&nbsp;</td>
           <td>-5.00 PLN</td>
         </tr>
         <tr>
           <td align="right">Podsuma:&nbsp;&nbsp;&nbsp;</td>
           <td>20.00 PLN</td>
         </tr>
         <tr>
           <td align="right">VAT:&nbsp;&nbsp;&nbsp;</td>
           <td>1.39 PLN</td>
         </tr>
         <tr>
           <td align="right">Razem:&nbsp;&nbsp;&nbsp;</td>
           <td>21.39 PLN</td>
         </tr>
       </table><br>
        Jeżeli opcja ta będzie wyłączona rabat nie będzie wykazywany w podsumie zamówienia. W tym przypadku kolejność wyświetlania należy ustawić po podsumie zamówienia.<br>Na przykład:
         <br>
         <table border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder">
           <tr>
             <td align="right">zakupiony przedmiot x 1:&nbsp;&nbsp;&nbsp;</td>
             <td>25.00 PLN</td>
           </tr>
           <tr>
             <td align="right">Podsuma:&nbsp;&nbsp;&nbsp;</td>
             <td>25.00 PLN</td>
           </tr>
           <tr>
             <td align="right">Kupon rabatowy nr XYZ:&nbsp;&nbsp;&nbsp;</td>
             <td>-5.00 PLN</td>
           </tr>
           <tr>
             <td align="right">VAT:&nbsp;&nbsp;&nbsp;</td>
             <td>1.39 PLN</td>
           </tr>
           <tr>
             <td align="right">Razem:&nbsp;&nbsp;&nbsp;</td>
             <td>21.39 PLN</td>
           </tr>
         </table>
         <br>
         <span class="notice"><strong>UWAGA:</strong> Jeżeli ceny w sklepie są wyświetlane z podatkiem VAT, podsuma zamówienia zawsze uwzględnia udzielony rabat. </span></li>
   <li><strong>Długość losowego kodu</strong>    <br>
     Jeżeli nie zostanie wprowadzony kod kuponu rabatowego, program automatycznie go wygeneruje. W tym miejscu można zdefiniować długość kodu kuponu rabatowego w przypadku automatycznego generowania. </li>
   <li><strong>Wyświetlanie rabatu dla każdej grupy podatku ?</strong> <br>
   W przypadku włączenia tej opcji rabat będzie wyświetlany w osobnej linii dla każdej stawki podatku VAT, jeżeli w zamówieniu znajdują się produkty o różnych stawkach podatku. </li>
   <li><b>Wersje językowe</b><br>
     Jeżeli sklep jest używany w wielu wersjach językowych włączenie tej opcji powoduje, iż informacja o udzielonym rabacie w podsumowaniu zamówienia zostanie wyświetlona zgodnie z wybranym w sklepie językiem. Treść informacji znajduje się w pliku includes/languages/<em>wybrany_jezyk</em>/modules/order_total/ot_discount_coupon.php. Jeżeli sklep jest tylko w jednym języku treść informacji mozna zdefiniować w polu <b>Format informacji w podsumowaniu zamówienia</b>.</li>
   <li><strong>Format informacji w podsumowaniu zamówienia</strong>    <br>
     Informacja wyświetlana w podsumowaniu zamówienia. Można użyć następujących wartości zmiennych.:
       <br>
     [code]
     <br>
     [coupon_desc]
     <br>
     [percent_discount]
     <br>
     [min_order]
     <br>
     [number_available]
     <br>
   [tax_desc] </li>
 </ul>
 <h3><a name="creating"></a>Tworzenie kuponów rabatowych</h3>
 <p>Wybierz w Panelu Administratora <strong>Sklep   &gt; Kupony rabatowe</strong>. Kliknij przycisk
   <strong>Nowy kupon</strong> w celu dodania nowego kuponu. Jedynym koniecznym do wypełnienia polem jest <i>Rabat procentowy</i>. </p>
 <p>Po utworzeniu kuponu można go przekazać klientom sklepu w dowolnej formie (mail, tel, itp.). Klient do wykorzystania kuponu potrzebuje w zasadzie tylko kod zawarty w kuponie.</p>
 <p> Rabat udzielony przy pomocy kuponów rabatowych jest wyświetlany w podsumowaniu zamówienia, w historii zamówień oraz podczas obróki zamówienia w panelu administracyjnym.
</p>
 <p>Rabat jest udzielany przed wyliczeniem podatku VAT. </p>
 <h4><a name="fields"></a>Opis pól kuponu rabatowego: </h4>
 <ul>
   <li> <strong>Kod kuponu</strong>     <br>
     Kod, który jest przekazywany klientowi w celu wykorzystania kuponu rabatowego. Kod może być ciągiem znaków alfanumerycznych o długosi max. 32 znaki. Jeżeli pole to nie zostanie wypełnione - kod zostanie wygenerowany automatycznie. Pole nie może być edytowane po zapisaniu kuponu. </li>
   <li><strong>Opis</strong>     <br>
     Opis dostępny dla administratora. Pole to nie jest widoczne dla klientów, chyba że zostanie zdefiniowane w konfiguracji wyświetlania informacji w podsumowaniu zamówienia. Zobacze &quot;Format informacji w podsumowaniu zamówienia&quot; w <a href="#configure">Konfigurowanie modułu kuponów rabatowych</a>.</li>
   <li><strong>Rabat procentowy</strong>     <br>
     Procentowy rabat od kwoty zamówienia.
    Należy wprowadzić wartość w formacie ułamka, np. 0.15 zamiat 15 lub 15%.
     Pole nie może być edytowane po zapisaniu kuponu. </li>
   <li><strong>Określona kwota rabatu</strong><br>
     Mozna wprowadzić określoną kwotę rabatu jaka będzie odliczona od zamówienia po wprowadzeniu kodu z kuponu rabatowego zamiast odliczenia procentowego.Przy wpowadzaniu wartości kwotowej należy w określić minimalną kwotę zamówienia przy której rabat może zostać udzielony. Kwotę należy podać jakoi liczbę bez symboli waluty, np. 50 a nie 50 PLN. Jeżeli jest używany rabat procentowy należy to pole pozostawić puste. Pole nie może być edytowane po zapisaniu kuponu.</li>
   <li><strong>Data początkowa</strong>     <br>
     Określenie daty po której klient może użyć kuponu rabatoweog. Jeżeli pole nie jest wypełnione - kupon może zostać użyty bezpośrednio po utworzeniu.</li>
   <li><strong>Data końcowa</strong>     <br>
     Określenie daty do kiedy klient może wykorzystać otrzymany kupon rabatowy. Jeżeli pole nie jest wypełnione - kupon rabatowy zachowuje swoją ważność przez czas nie określony.</li>
   <li><strong>Maksymalna ilość użyć</strong>     <br>
     Określenie ile razy klient może użyć przyznany kupon rabatowy. Pozostawienie pola pustego lub wpisanie wartości 0 powoduje, że klient będzie mógł wykorzystać kupon dowolną ilość razy.</li>
   <li><strong>Minimalne zamówienie</strong>     <br>
     Minimalna kwota zamówienia, od której klient będzie mógł skorzystać z kuponu rabatowego. Pozostawienie pola pustego lub wpisanie wartości 0 powoduje, że nie ma minimalnej wartości zamówienia. Pole nie może być edytowane po zapisaniu kuponu.</li>
   <li><strong>Maksymalne zamówienie</strong>     <br>
     Maksymalna kwota zamówienia do której może być wykorzystany kupon rabatowy. Pozwala ograniczyć wielkość udzielonego rabatu. Jeżeli kwota zamówienia jest wyższa niż określona w wartości maksymalnej, to raba zostanie naliczony od ustalonej wartości maksymalnej. Jeżeli pole pozostanie puste lub wpisze się wartość 0 - wówczas nie będzie górnej granicy kwoty zamówienia od której może być udzielony rabat. Pole nie może być edytowane po zapisaniu kuponu.</li>
   <li><strong>Ilość dostępnych kuponów</strong>     <br>
     Wartość ta pozwala na określenie ile kuponów może żostać wykorzystanych w sklepie. Można dzięki tem limitować wykorzystanie kuponów np. dla pierwszych 10 klientów, którzy dokonają zakupów wyznaczonego dnia.</li>
 </ul>
 <h4><a name="percentage_discounts"></a>Jak utworzyć kupon z rabatem procentowym.</h4>
 <p>Aby utworzyć kupon, w którym rabat będzie określony jako procent od kwoty zamówienia wystarczy wypełnić tylko pole <i>Rabat procentowy</i>. Pozostałe pola kuponu są opcjonalne..</p>
 <h4><a name="fixed_discounts"></a>Jak utworzyć kupon z ustaloną kwotą rabatu.</h4>
 <p>W celu utworzenia kuponu rabatowego z ustaloną kwotą udzielonego rabatu można wypełnić nowy kupon na dwa sposoby:<br>W pierwszym z nich należy ustawić następujące parametry : <b>Minimalne zamówienie</b> (minimalna kwota zamówienia powyżej której klient będzie mógł skorzystać z kupnu), <b>Kwota rabatu</b> (wartość kwotowa udzielonego rabatu).<br>Można również wpisać procentową wartość oraz kwoty <b>Minimalnego</b> i <b>Maksymalnego</b> zamówienia (kwota maksymalnego zamówienia musi być równa minimalnemu zamówieniu).<br> W tym przypadku jeżeli podana jest procentowa wartość rabatu i kwota maksymalnego zamówienia jest równa kwocie minimalnego zamówienia rabat jest przeliczany na kwotę stanowiącą procent maksymalnego zamówienia.</p>
 <p>Na przykład jeżeli chcemy dać rabat 5 PLN przy zamówieniu na kwotę 25 PLN lub wyższym należy ustawić następujące wartości: Minimalne i Maksymalne zamówienie wpisujemy kwotę 25. W pole Rabat procentowy wpisujemy wartość 0.2. W wyniku tego rabat bezie udzielony w kwocie 5 PLN dla wszystkich zamówień powyżej 25 PLN (20% z 25).</p>
</body>
</html>