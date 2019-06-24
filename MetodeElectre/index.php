<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="costume_css" rel="stylesheet">
    <title>Metode Electre </title> 
    
</head>
    <body>
      <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="costume_css" rel="stylesheet">
    <title>Metode Electre </title> 
    <?php include("koneksi.php"); ?>
</head>
    <body>
        <ul>
        <li><a href="index.php">Input Alternatif</a></li>
        <li><a href="index2.php">Kalkulasi Alternatif</a></li>
        </ul>
      <table border="1" style="width:30%">
          <h1>LIST ALTERNATIF</h1>
          <tr>          
              <td>NAMA ALTERNATIF</td>
              <td>HARGA</td>
              <td>KUALITAS</td>
              <td>FITUR</td>
              <td>POPULER</td>
              <td>KEAWETAN</td>
          </tr>
          <?php
          $query="Select * from alternatiff";
          $hasil=mysqli_query($koneksi,$query);             
          while($data=mysqli_fetch_array($hasil, MYSQLI_ASSOC)){
          ?>
          <tr>
              <td><?php echo $data['namaAlternatif']; ?></td>
              <td><?php echo $data['harga']; ?></td>
              <td><?php echo $data['kualitas']; ?></td>
              <td><?php echo $data['fitur']; ?></td>
              <td><?php echo $data['populer']; ?></td>
              <td><?php echo $data['keawetan']; ?></td>
          </tr> 
          <?php } ?>
      </table>
        
        
        <?php  ?>
     
            <form method="post" enctype="multipart/form-data">
            <h2>Input Bobot Kriteria</h2>
            
            <ul>
            <li><label for="fileSelect">Nama:</label>
            <input type="text" name="namaAlternatif" id="namaAlternatif"><br></li>
            <li><label for="fileSelect">Harga:</label>
            <input type="text" name="kriteriaHarga" id="kriteriaHarga"><br></li>
            <li><label for="fileSelect">Kualitas:</label>
            <input type="text" name="kriteriaKualitas" id="kriteriaKualitas" ><br></li>
            <li><label for="fileSelect">Fitur:</label>
            <input type="text" name="kriteriaFitur" id="kriteriaFitur"><br></li>
            <li><label for="fileSelect">Populer:</label>
            <input type="text" name="kriteriaPopuler" id="kriteriaPopuler"><br></li>
            <li><label for="fileSelect">Keawetan:</label>
            <input type="text" name="kriteriaKeawetan" id="kriteriaKeawetan"><br></li>
            </ul>
            
            <input type="submit" name="uploadFile" value="Tambah" id="uploadFile">
            <br>
            </form>
        
        <?php
            if(isset($_POST['uploadFile'])){
            $namaAlternatif=$_POST['namaAlternatif'];
            $kriteriaHarga=intval($_POST['kriteriaHarga']);
            $kriteriaKualitas=intval($_POST['kriteriaKualitas']);
            $kriteriaFitur=intval($_POST['kriteriaFitur']);
            $kriteriaPopuler=intval($_POST['kriteriaPopuler']);
            $kriteriaKeawetan=intval($_POST['kriteriaKeawetan']);
            $query="INSERT INTO alternatiff (`namaAlternatif`, `harga`, `kualitas`, `fitur`, `populer`, `keawetan`) VALUES ('$namaAlternatif', '$kriteriaHarga', '$kriteriaKualitas', '$kriteriaFitur', '$kriteriaPopuler', '$kriteriaKeawetan');";
            mysqli_query ($koneksi,$query);
                header('Location:index.php');
            }
                                             
        

        ?>
    </body>
    
</html>