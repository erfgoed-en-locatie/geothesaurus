$(document).ready(initSorttables)

function initSorttables(){
	$('table.sortable thead th').on('click', sortOnTH)
}

function sortOnTH(e){
	var $target = $(e.target),
		$thead_tr = $target.parent(),
		index = $thead_tr.children().toArray().indexOf(e.target),
		dataType = e.target.textContent,
		$tbody = $thead_tr.parents('table').find('tbody'),
		$rows = $tbody.find('tr'),
		order;

	if($target.hasClass('asc')){
		$target.removeClass('asc');
		$target.addClass('desc');
		order = 1;
	} else {
		$target.removeClass('desc');
		$target.addClass('asc');
		order = -1;
	}

	$rows.sort(function(a,b){
		var aContent = a.children[index].textContent,
			bContent = b.children[index].textContent;

		if(sortFunctions[dataType]) return sortFunctions[dataType](aContent, bContent, order);
		else return aContent > bContent ? 1 * order : -1 * order;
	});

	$tbody.html($rows);
}

var sortFunctions = {

};