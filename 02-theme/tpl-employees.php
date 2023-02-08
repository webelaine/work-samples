<?php
/*
 * Template Name: Employee Directory
 */
get_header(); ?>
<main class="page-wrapper striped-ghostweave" id="theContent" data-swiftype-index="true">
	<div class="stmu-single-block">
		<div class="max-width twothirdssplit directory">
			<div class="twoleft text-center" id="browseByLetter">
				<h2 class="h3 text-left" id="browse">Browse by Last Name</h2>
				<button class="small-btn" id="a">A</button>
				<button class="small-btn" id="b">B</button>
				<button class="small-btn" id="c">C</button>
				<button class="small-btn" id="d">D</button>
				<button class="small-btn" id="e">E</button>
				<button class="small-btn" id="f">F</button>
				<button class="small-btn" id="g">G</button>
				<button class="small-btn" id="h">H</button>
				<button class="small-btn" id="i">I</button>
				<button class="small-btn" id="j">J</button>
				<button class="small-btn" id="k">K</button>
				<button class="small-btn" id="l">L</button>
				<button class="small-btn" id="m">M</button>
				<button class="small-btn" id="n">N</button>
				<button class="small-btn" id="o">O</button>
				<button class="small-btn" id="p">P</button>
				<button class="small-btn" id="q">Q</button>
				<button class="small-btn" id="r">R</button>
				<button class="small-btn" id="s">S</button>
				<button class="small-btn" id="t">T</button>
				<button class="small-btn" id="u">U</button>
				<button class="small-btn" id="v">V</button>
				<button class="small-btn" id="w">W</button>
				<button class="small-btn" id="x">X</button>
				<button class="small-btn" id="y">Y</button>
				<button class="small-btn" id="z">Z</button>
				<p>Marianists are listed separately in our <a href="/campuslife/spiritual/marianist-directory/">Marianist Directory</a>.</p>
			</div>
			<div class="oneright text-center">
				<h2 class="h3" id="keyword">Keyword Search</h2>
				<form method="POST" class="search-container" onsubmit="return skipToResults();">
					<label for="employeeSearch" class="show-for-sr">Search the employee directory</label>
					<input type="text" name="employeesearch" id="employeeSearch" placeholder="David, professor, Garni" value="">
					<button type="submit" name="dirsearch">&#xf002;<span class="show-for-sr">Search</span></button>
				</form>
			</div>
		</div>
	</div>
	<div class="stmu-single-block">
		<div class="max-width" id="employeeResults">
			<p>Please browse or search above to view employees.</p>
		</div>
	</div>
</main>
<?php get_footer(); ?>