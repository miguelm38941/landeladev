<!--
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
-->
<link href="<?= base_url('fonts/fonts.css') ?>" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdn.rawgit.com/Dogfalo/materialize/fc44c862/dist/css/materialize.min.css">
    <!--script type="text/javascript" src="https://code.jquery.com/jquery-2.2.1.min.js"></script-->
    <script src="<?= base_url('js/jquery-2.1.1.min.js') ?>"></script>
    <script src="https://cdn.rawgit.com/Dogfalo/materialize/fc44c862/dist/js/materialize.min.js"></script>
<script type="text/javascript" src="<?= base_url('js/chart.min.js') ?>"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<script type="text/javascript">
window.base_url='<?= base_url() ?>';
</script>
<link rel="stylesheet" href="<?= base_url('css/styles.css') ?>"/>
<script type="text/javascript" src="<?= base_url('js/common.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('js/lgedit.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('js/pagination.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('js/fingerprint/custom.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('js/fingerprint/ajaxMask.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('js/fingerprint/jquery.timer.js') ?>"></script>

<script type="text/javascript">
$(document).ready(function(){


  $('#myTable').pageMe({
    pagerSelector:'#myPager',
    activeColor: 'blue',
    prevText:'Anterior',
    nextText:'Siguiente',
    showPrevNext:true,
    hidePageNumbers:false,
    perPage:10
  });


/*var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};*/

$('#cmd').click(function () {   
    doc.fromHTML($('#content').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    doc.save('sample-file.pdf');
});

        $("#btnPrint").click(function () { 
            var divContents = $("#dvprinting").html();
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>DIV Contents</title>');
            printWindow.document.write('<Import materialize.css><link rel="stylesheet" href="https://cdn.rawgit.com/Dogfalo/materialize/fc44c862/dist/css/materialize.min.css"><link rel="stylesheet" href="<?= base_url('css/styles.css') ?>"/>'); 
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });



//Export HTML Table Data to Excel using JavaScript
//exportTableToExcel
$('#printBtn').click(function(){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById('myTable');
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = 'landela_export.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
});


});
</script>
