<?php include_once 'user.php'; ?>
<?php include_once 'helper.php'; ?>
<?php if( User::$user->hasParticipated == true ): ?>
	<div class="participated-notice">
		<h2>Danke für dein Interesse. <br /> Aber du hast an dieser Umfrage schon teilgenommen.</h2>	
	</div>
<?php else: ?>			
	<form id="question-form">
		<h3>1. Essen</h3>
		<span class="form">
			<label for="cat1_question1">1.1 War das Essen für Sie vielseitig?</label>
			<ul>
				<li><input type="radio" name="cat1_question1" value="1" <?php Helper::setCheckboxes( "cat1_question1_1" ); ?>><span class="text">Wenn jeden Tag Nudeln vielseitig heisst...</span></li>
				<li><input type="radio" name="cat1_question1" value="2" <?php Helper::setCheckboxes( "cat1_question1_2" ); ?>><span class="text">Immerhin gab es am Wochenende mal was andres.</span></li>
				<li><input type="radio" name="cat1_question1" value="3" <?php Helper::setCheckboxes( "cat1_question1_3" ); ?>><span class="text">Man gibt sich Mühe öfter mal was Anderes aufzutischen.</span></li>
				<li><input type="radio" name="cat1_question1" value="4" <?php Helper::setCheckboxes( "cat1_question1_4" ); ?>><span class="text">Jeden Tag was Neues. Das ist Abenteuer pur!</span></li>
			</ul>
		</span>
		<span class="form">
			<label for="cat1_question2">1.2 Erhalten Sie zu dem Mitagessen jeweils Salat oder Gemüse?</label>
			<ul>
				<li><input type="radio" name="cat1_question2" value="1" <?php Helper::setCheckboxes( "cat1_question2_1" ); ?>><span class="text">Es war grün. Ob es Gemüse war, weiss ich nicht.</span></li>
				<li><input type="radio" name="cat1_question2" value="2" <?php Helper::setCheckboxes( "cat1_question2_2" ); ?>><span class="text">Hier und da kann man auf ein paar Erbsen treffen. Manchmal auch Mais.</span></li>
				<li><input type="radio" name="cat1_question2" value="3" <?php Helper::setCheckboxes( "cat1_question2_3" ); ?>><span class="text">Ausreichend.</span></li>
				<li><input type="radio" name="cat1_question2" value="4" <?php Helper::setCheckboxes( "cat1_question2_4" ); ?>><span class="text">Massig. Mehr Vitamine als ich brauche kann!</span></li>
			</ul>
		</span>
		<h3>2. Personal</h3>
		<span class="form">
			<label for="cat2_question1">2.1 Nehmen Sie das Personal als freundlich wahr?</label>
			<ul>
				<li><input type="radio" name="cat2_question1" value="1" <?php Helper::setCheckboxes( "cat2_question1_1" ); ?>><span class="text">Ich werde also nicht aus reiner Tyrannei Stunden in der kalten Badewanne liegen lassen?</span></li>
				<li><input type="radio" name="cat2_question1" value="2" <?php Helper::setCheckboxes( "cat2_question1_2" ); ?>><span class="text">Ich glaube heutzutage darf man nicht mehr erwarten.</span></li>
				<li><input type="radio" name="cat2_question1" value="3" <?php Helper::setCheckboxes( "cat2_question1_3" ); ?>><span class="text">Kurz nach dem Schichtwechsel sind sie immer sehr sehr nett.</span></li>
				<li><input type="radio" name="cat2_question1" value="4" <?php Helper::setCheckboxes( "cat2_question1_4" ); ?>><span class="text">Wahre Engel! Wenn nur die Enkel so wären!</span></li>
			</ul>
		</span>
		<span class="form">
			<label for="cat2_question2">2.2 Kann Ihnen das Personal bei Fragen weiterhelfen?</label>
			<ul>
				<li><input type="radio" name="cat2_question2" value="1" <?php Helper::setCheckboxes( "cat2_question2_1" ); ?>><span class="text">Ich komm' mir vor wie bei Media-Markt!</span></li>
				<li><input type="radio" name="cat2_question2" value="2" <?php Helper::setCheckboxes( "cat2_question2_2" ); ?>><span class="text">Man braucht etwas Glück, manchmal auch etwas mehr.</span></li>
				<li><input type="radio" name="cat2_question2" value="3" <?php Helper::setCheckboxes( "cat2_question2_3" ); ?>><span class="text">In etlichen Fällen war mir das Personal eine Hilfe.</span></li>
				<li><input type="radio" name="cat2_question2" value="4" <?php Helper::setCheckboxes( "cat2_question2_4" ); ?>><span class="text">Noch keine Frage blieb unbeantwortet.</span></li>
			</ul>
		</span>
		<span class="form">
			<label for="cat2_question3">2.3 Fühlen Sie sich wohl in dieser Atmosphäre?</label>
			<ul>
				<li><input type="radio" name="cat2_question3" value="1" <?php Helper::setCheckboxes( "cat2_question3_1" ); ?>><span class="text">In welchem der neun Höllenkreise befinde ich mich?</span></li>
				<li><input type="radio" name="cat2_question3" value="2" <?php Helper::setCheckboxes( "cat2_question3_2" ); ?>><span class="text">Mir bleibt wohl keine andere Wahl.</span></li>
				<li><input type="radio" name="cat2_question3" value="3" <?php Helper::setCheckboxes( "cat2_question3_3" ); ?>><span class="text">Es ist nicht die Karibik - aber es lässt sich gut leben.</span></li>
				<li><input type="radio" name="cat2_question3" value="4" <?php Helper::setCheckboxes( "cat2_question3_4" ); ?>><span class="text">Ich geniesse meine Zeit hier in vollen Zügen.</span></li>
			</ul>
		</span>
		
		<h3>3. Hilfsmittel</h3>
		<span class="form">
			<label for="cat3_question1">3.1 <span class="text">Stehen Ihnen genügend Hilfsmittel für den Alltag zur Verfügung?</span></label>
			<ul>
				<li><input type="radio" name="cat3_question1" value="1" <?php Helper::setCheckboxes( "cat3_question1_1" ); ?>><span class="text">Ich erhalte ausreichend Schlafmittel, ja.</span></li>
				<li><input type="radio" name="cat3_question1" value="2" <?php Helper::setCheckboxes( "cat3_question1_2" ); ?>><span class="text">Ich komme durch den Tag. Manchmal hört man zumindest mein verzweifeltes Läuten.</span></li>
				<li><input type="radio" name="cat3_question1" value="3" <?php Helper::setCheckboxes( "cat3_question1_3" ); ?>><span class="text">Das Equipment ist zwar meist etwas in die Jahre gekommen. Aber ich bin's ja auch.</span></li>
				<li><input type="radio" name="cat3_question1" value="4" <?php Helper::setCheckboxes( "cat3_question1_4" ); ?>><span class="text">Mehr als ich brauche.</span></li>
			</ul>
		</span>
		<span class="form">
			<label for="cat2_question2">3.2 <span class="text">Wenn Sie weitere Hilfsmittel wünschen, wird ihrem Wunsch entsprochen?</span></label>
			<ul>
				<li><input type="radio" name="cat3_question2" value="1" <?php Helper::setCheckboxes( "cat3_question2_1" ); ?>><span class="text">Zunächst höhnisches Gelächter. Dann gibt man mir Pillen. </span></li>
				<li><input type="radio" name="cat3_question2" value="2" <?php Helper::setCheckboxes( "cat3_question2_2" ); ?>><span class="text">Man sagt mir immer, man würde sich drum kümmern.</span></li>
				<li><input type="radio" name="cat3_question2" value="3" <?php Helper::setCheckboxes( "cat3_question2_3" ); ?>><span class="text">Wenn man seine Wünsche vernünftig begründen kann. Mit dem entsprechenden Kleingeld.</span></li>
				<li><input type="radio" name="cat3_question2" value="4" <?php Helper::setCheckboxes( "cat3_question2_4" ); ?>><span class="text">Selbst meinen persönlichen Diener haben Sie mir nicht ausgeschlagen!</span></li>
			</ul>
		</span>
		
		<input type="hidden" name="question" value="question" />	
		<input type="submit" value="senden" />
	</form>
<?php endif; ?>
