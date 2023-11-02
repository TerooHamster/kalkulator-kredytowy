{extends file="main.tpl"}

{block name=footer}{/block}

{block name=content}
		<form action="{$conf->action_root}logout" method="post">
		<button type="submit" class="pure-button pure-button-primary">Wyloguj</button>
		</form>
		<br>

<div>
    <form class="pure-form pure-form-stacked" action="{$conf->action_root}calcCompute" method="post">
	
        <label for="kwota">Kwota kredytu</label>
	
        <input id="kwota" type="text" name="kwota" value="{$form->kwota}"/>
        <label for="wybor">Okres kredytu</label>
		<select id="wybor" name="wybor">
		<option value="30d">30 dni</option>
		<option value="60d">60 dni</option>
		<option value="3m">3 miesiące</option>
		<option value="6m">6 miesięcy</option>
		<option value="12m">12 miesięcy</option>
		</select>
        </br>
		<button type="submit" class="pure-button pure-button-primary">Oblicz</button>
    </form>
	<div>
	


{if isset($res->parametr1) &&  isset($res->parametr2) &&  isset($res->parametr3) &&  isset($res->parametr4) &&  isset($res->parametr5) &&  isset($res->parametr6)}

	<h4>
	Dane dotyczące twojej pożyczki : 
	<br>
	<br>
	<p class="res">
	Kwota pożyczki : {$form->kwota} pln
	<br>
	Czas spłaty : {$res->rodzaj} 
	<br>
	Oprocentowanie : {round($res->oprocentowanie)} %
	<br>
	Odsetki miesieczne : {round($res->odsetki)} pln
	<br>
	Całkowity koszt pożyczki : {round($res->koszt)} pln
	<br>
	Miesięczna rata : {round($res->miesiac)} pln
	<br>
	Całkowita kwota do oddania : {round($res->calkowita)} pln	
	</p>
	</h4>
{/if}

</div>
</div>

{/block}