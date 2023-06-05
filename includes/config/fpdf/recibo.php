<?php
    include_once '../database.php';
    include_once '../user.php';
    include_once '../user_session.php';

    error_reporting(0);

    $db = new DB();
    $user = new User();
    $userSession = new userSession();

    $idUsuario = "";
    $nombreCompleto = $_POST ['nombreCompleto' ];
    $telefono       = $_POST ['telefono'       ];
    $calle          = $_POST ['calle'          ];
    $numero         = $_POST ['numero'         ];
    $colonia        = $_POST ['colonia'        ];
    $ciudad         = $_POST ['ciudad'         ];
    $estado         = $_POST ['estado'         ];
    $cp             = $_POST ['cp'             ];
    $entreCalles    = $_POST ['entreCalles'    ];
    $total          = $_POST ['sum'            ];
    $carrito        = $_POST ['carrito'        ];
    $idActualUser   = $_POST ['idUser'         ];
    $codigos        = $_SESSION['codes'];

    // Elimina el carrito en caso de haber comprado del carrito
    if ($carrito == 1) {
        $queryEliminaCarro = "DELETE FROM carrito WHERE usuariosid = '${idActualUser}'";
        $resultadoEliminaCarro = mysqli_query($db -> connect(), $queryEliminaCarro);  
    }

    foreach($codigos as $code) {
        $queryDisminuyeInventario = "UPDATE productos
                                     SET existencias = existencias - 1
                                     WHERE librocodigo = '${code}'";
        $resultadoDisminuyeInventario = mysqli_query($db -> connect(), $queryDisminuyeInventario);
    }

    $datos= $_SESSION['data'];
    
include_once ('fpdf/pdf.php');

$data = [];
foreach($datos as $line)
    $data[] = explode(';',trim($line));

$pdfc = new PDF();

$pdfc -> AliasNbPages();
$pdfc -> AddPage();
$pdfc -> SetFont('Times','',12);


$pdfc->Cell(100,7,"Fecha de compra: ".date('y-m-d h:i:s'),0,1,'C');

$pdfc->Ln(6);

$pdfc->SetFillColor(1, 19, 34);
$pdfc->SetTextColor(255);
$pdfc->Cell(120,6,"Datos del cliente",0,1,'L',true);

$pdfc->SetTextColor(0);
$pdfc -> Write(6, $nombreCompleto);
$pdfc -> Ln();
$pdfc -> Write(6, "Telefono: ".$telefono);
$pdfc->Ln(); 

$pdfc->SetFillColor(1, 19, 34);
$pdfc->SetTextColor(255);
$pdfc -> Ln();
$pdfc->Cell(120,6,"Datos del envio",0,1,'L',true);

$pdfc->SetTextColor(0);
$pdfc -> Write(6, "Av. ".$calle. " ".$numero. "Col. ".$colonia.", ".$ciudad." ". $estado.", ".$cp);
$pdfc->Ln(); 
$pdfc -> Write(6, "Entre calles: ".$entreCalles);
$pdfc->Ln(10); 
$header = array('Cantidad', 'Descripcion', 'Precio', 'Descuento', 'Importe');

$pdfc -> SetFillColor(1, 19, 34);
$pdfc -> SetTextColor(255);
$pdfc -> SetDrawColor(1, 19, 34);
$pdfc -> SetLineWidth(.1);
$pdfc -> SetFont('','B');

$w = array(25, 90, 25, 25);
for($i=0;$i<count($header);$i++)
    $pdfc -> Cell($w[$i],7,$header[$i],1,0,'C',true);
$pdfc -> Ln();

$pdfc -> SetFillColor(245,245,255);
$pdfc -> SetTextColor(0);
$pdfc -> SetFont('');

$fill = false;

foreach($data as $row)
{
    $pdfc -> Cell($w[0],7,$row[0],'LR',0,'L',$fill);
    $pdfc -> Cell($w[1],7,$row[1],'LR',0,'L',$fill);
    $pdfc -> Cell($w[2],7,$row[2],'LR',0,'L',$fill);
    $pdfc -> Cell($w[3],7,$row[3],'LR',0,'L',$fill);
    $pdfc -> Cell($w[4],7,$row[4],'LR',0,'L',$fill);
    $pdfc -> Ln();
    $fill = !$fill;
}

$pdfc -> Cell(190,6,'','T');
$pdfc -> Ln();

$pdfc->SetTextColor(0);
$pdfc->Cell(50,8,"Total a envio: $100.00",0,0,'L',true);
$pdfc -> Ln();
$pdfc->Cell(50,8,"Total a pagar: $".$total,0,0,'L',true);

$pdfc->Output("recibos/recibo_FraluL.pdf",'F');
echo "<script language='javascript'>window.location.href = 'recibos/recibo_FraluL.pdf';</script>";?>

<?php
    unset($_SESSION['data']);
/*
    $query = "UPDATE usuarios SET token = null WHERE id = '${userActualID}'";
    $result = mysqli_query($db -> connect(), $query);*/
?>