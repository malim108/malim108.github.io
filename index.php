<?php 
session_start();
require_once 'connect.php';
if(isset($_SESSION['VERSTREKEN'])){
    unset($_SESSION['VERSTREKEN']);
}
if(isset($_SESSION['MEER'])){
    unset($_SESSION['MEER']);
}
if (isset($_SESSION['KIJK'])){
    unset($_SESSION['KIJK']);
}

if(isset($_SESSION['SORTFILT'])){
$bind = $_SESSION['SORTFILT'];}
if(!isset($_SESSION['SORT_ID']) and !isset($_SESSION['SORTFILT'])){
    $sql= 'SELECT * FROM product';
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $resultaat = $stmt->fetchAll();
}
else if($_SESSION['SORT_ID'] == 1 and !isset($_SESSION['SORTFILT'])){
    $sql= 'SELECT * FROM product ORDER BY naam';
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $resultaat = $stmt->fetchAll();
}
else if($_SESSION['SORT_ID'] == 2 and !isset($_SESSION['SORTFILT'])){
    $sql= 'SELECT * FROM product ORDER BY prijs';
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $resultaat = $stmt->fetchAll();
}
else if($_SESSION['SORT_ID'] == 3 and !isset($_SESSION['SORTFILT'])){
    $sql= 'SELECT * FROM product ORDER BY prijs DESC';
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $resultaat = $stmt->fetchAll();
}
else if($_SESSION['SORT_ID'] == 1 and isset($_SESSION['SORTFILT'])){
    $sql= 'SELECT * FROM product WHERE typeProd = :type ORDER BY naam';
    $stmt = $link->prepare($sql);
    $stmt->bindValue(':type', $bind);
    $stmt->execute();
    $resultaat = $stmt->fetchAll();
    if(isset($_SESSION['FILTER'])){ unset($_SESSION['FILTER']);}
}
else if($_SESSION['SORT_ID'] == 2 and isset($_SESSION['SORTFILT'])){
    $sql= 'SELECT * FROM product WHERE typeProd = :type ORDER BY prijs';
    $stmt = $link->prepare($sql);
    $stmt->bindValue(':type', $bind);
    $stmt->execute();
    $resultaat = $stmt->fetchAll();
    if(isset($_SESSION['FILTER'])){ unset($_SESSION['FILTER']);}
}
else if($_SESSION['SORT_ID'] == 3 and isset($_SESSION['SORTFILT'])){
    $sql= 'SELECT * FROM product WHERE typeProd = :type ORDER BY prijs DESC';
    $stmt = $link->prepare($sql);
    $stmt->bindValue(':type', $bind);
    $stmt->execute();
    $resultaat = $stmt->fetchAll();
    if(isset($_SESSION['FILTER'])){ unset($_SESSION['FILTER']);}
}

if($_SESSION['naam'] == NULL){
fout("log je eerst in.", "login.php");
}
$naamses = $_SESSION['naam'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JFK Computers</title>
    <link rel="icon" type="image/x-icon" href="images/background/Group34.png">
    <link rel="stylesheet" href="CSS/webshop.css">
    <link rel="stylesheet" href="CSS/webshopM.css">
    <link rel="stylesheet" href="CSS/WebshopM2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">
</head>
<body>

<?php require_once 'navbar.php';?>

    <!--Extra NAV-->

    <div class="black-nav-custom">
        <div class="items-custom-nav" style="margin-left: 8.5rem;">
            <div class="dropdown">
                <button onclick="myFunction();" class="dropbtn button1" style="margin-left: 0; width: fit-content;"><span style="width: 5rem;">Filter</span></button>
                <div id="myDropdown" class="dropdown-content">
                  <a href="filter.php?FIL=-1<?php if(isset($_SESSION['ACTIVE_SORT'])){echo '&SORT=' .$_SESSION['ACTIVE_SORT'];}else{echo '&SORT=-1';}?>"> Alle Producten</a>
                  <a href="filter.php?FIL=1<?php if(isset($_SESSION['ACTIVE_SORT'])){echo '&SORT=' .$_SESSION['ACTIVE_SORT'];}else{echo '&SORT=-1';}?>"> Muizen</a>
                  <a href="filter.php?FIL=2<?php if(isset($_SESSION['ACTIVE_SORT'])){echo '&SORT=' .$_SESSION['ACTIVE_SORT'];}else{echo '&SORT=-1';}?>"> Toetsenborden</a>
                  <a href="filter.php?FIL=3<?php if(isset($_SESSION['ACTIVE_SORT'])){echo '&SORT=' .$_SESSION['ACTIVE_SORT'];}else{echo '&SORT=-1';}?>"> Koptelefoons</a>
                  <a href="filter.php?FIL=4<?php if(isset($_SESSION['ACTIVE_SORT'])){echo '&SORT=' .$_SESSION['ACTIVE_SORT'];}else{echo '&SORT=-1';}?>"> PCs</a>
                  <a href="filter.php?FIL=5<?php if(isset($_SESSION['ACTIVE_SORT'])){echo '&SORT=' .$_SESSION['ACTIVE_SORT'];}else{echo '&SORT=-1';}?>"> Laptops</a>
                </div>
            </div>
            <div class="dropdown" style="margin-left: 7rem;">
                <button onclick="myFunction2()" class="dropbtn" style="">Sorteren</button>
                <div id="myDropdown2" class="dropdown-content2">
                  <a href="filter.php?SORT=-1<?php if(isset($_SESSION['ACTIVE_FIL'])){echo '&FIL=' .$_SESSION['ACTIVE_FIL'];}else{echo '&FIL=-1';}?>"> Geen sort</a>
                  <a href="filter.php?SORT=1<?php if(isset($_SESSION['ACTIVE_FIL'])){echo '&FIL=' .$_SESSION['ACTIVE_FIL'];}else{echo '&FIL=-1';}?>"> Alfabetisch</a>
                  <a href="filter.php?SORT=2<?php if(isset($_SESSION['ACTIVE_FIL'])){echo '&FIL=' .$_SESSION['ACTIVE_FIL'];}else{echo '&FIL=-1';}?>"> Op prijs: Laag - hoog</a>
                  <a href="filter.php?SORT=3<?php if(isset($_SESSION['ACTIVE_FIL'])){echo '&FIL=' .$_SESSION['ACTIVE_FIL'];}else{echo '&FIL=-1';}?>"> Op prijs: Hoog - laag</a>
                </div>
            </div>
        </div>
    </div>

    
    <div class="Welkomsbericht" style="display: flex; justify-content: center; font-size: x-large; margin-top: 1rem;">
    <?php
    if($_SESSION['naam'] != NULL){
        echo 'Welkom ' .$naamses;
        if($_SESSION['admin'] == 1){echo " (admin)";}
    }
    ?>
    </div>

    <!--producten-->

<div style="display: flex; flex-wrap: wrap; align-items: center; margin-left: auto; margin-right: auto; width: 100%;">
<?php 
if(isset($_SESSION['FILTER'])){
    $resultaat = $_SESSION['FILTER'];
}

foreach($resultaat as $producten): 
    $prodid = $producten['productID'];
    ?>
    <div class="custom-container-card">
        <div class="card-image">
            <img src="<?php echo $producten['foto']?>" alt="" style="margin-bottom: 0;" draggable=false>
        </div>
        <div class="NameNPrice">
            <p><?php echo $producten['naam']?></p>
            <p style="display: flex; justify-content: center; color: #76B900; margin-bottom: 0;"><?php echo "€" .$producten['prijs']?></p>
            <hr>
        </div>
        <div class="card-buy-buttonC">
            <?php if($producten['voorraad'] != 0){?>
                <?php if($producten['Edities'] == "Ja"){?>
            <a href="toevoegen.php?PROD_ID=<?php echo $prodid;?>&ED=<?php echo '1';?>" style="margin-bottom: 0.5rem; background-color: #76B900;">Toevoegen aan wagentje</a>
                <?php }else{?>
            <a href="toevoegen.php?PROD_ID=<?php echo $prodid;?>" style="margin-bottom: 0.5rem; background-color: #76B900;">Toevoegen aan wagentje</a>
                    <?php }?>
            <?php }else{?>
                <a href="" style="background-color:rgb(90, 90, 90); margin-bottom: 0.5rem;">Uitverkocht</a>
                <?php
            }?>
            <a href="detail.php?PROD_ID=<?php echo $prodid;?>" style="background-color:rgb(79, 125, 0);">Meer info</a>
        </div>
        <div class="card-buy-button-del">
            <?php if($_SESSION['admin'] == 1): ?>
                <button type="submit" name="delete" id="delete"><a href="itemdel.php?ID=<?php echo $prodid;?>">Verwijder item</a></button>
                <a href="wijzigen.php?ID=<?php echo $prodid;?>" class="wijzig-btn">Wijzig item</a>
                <?php 
                ?>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?> 
</div>
<br>

<?php
if($_SESSION['admin'] == 1){
    ?>
    <hr>
    <div style="display: flex; justify-content: center;">
    <a href="newitem.php" class="new-item-link">Nieuw product</a>
    </div>
    <?php
}
?>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.index.php );
    }
</script>


<!-- Footer-->
<footer class="py-5 bg-dark">
        <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">JFK Computers</p></div>
        <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">Website stage Milan Vermeersch</p></div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>