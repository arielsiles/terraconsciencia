fetch('./PHP/getRanking.php')
.then(response => response.text())
.then(tableContent => {
    document.getElementById('rankingTable').innerHTML = tableContent;
});