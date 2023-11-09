<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deal Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<style>
    #contentsDiv{
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #imgsDiv, #detailsDiv{
        height: 500px;
    }

    #bigimg{
        width: 550px;
        min-height: 300px;
        max-height: 400px;
    }

    .smlimgsDiv{
        display: flex;
        width: 550px;
        margin-top: 10px;
        flex-wrap: wrap;
        margin-left: 6px;
    }

    .smimgs{
        height: 80px;
        width: 100px;
        border: 1px gray solid;
    }

    .breadcrumb{
        background-color: transparent;
        border: 1px lightgray solid;
        font-size: 12px;
        color: darkgrey;
        margin-top: 10px;
    }

    .breadcrumb-item, .breadcrumb-item a{
        color: darkslategray !important;
        font-weight: bold;
    }

    .active{
        color: black;
        font-weight: normal;
    }

    #detailsDiv{
        width: 300px;
    }

    #title, #description{
        word-wrap: break-word;
    }
</style>
<body>
    <div class = "container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="seeDeals.php">Home</a></li>
                <li id = "titleLi"class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>

        <div id = "contentsDiv">
            <div id = "imgsDiv" class = "mr-5">
                <div id = "bigimgDiv">
                    <img id = "bigimg" src="">
                </div>

                <div id = "smlimgsDiv">
                </div>
            </div>

                <div id = "detailsDiv">
                    <h4 id="title"></h4>
                    <p id = "description">
                    </p>
                    <p id = "tscs">
                    </p>
                    <p id = "comment">
                    </p>
                    <h3 id = "price"></h3>
                    <div id = "btnDiv" class = "mt-3">
                        <button class = "btn btn-lg btn-primary mr-2">Enquire Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    
    <script>
        let deal = null;

        window.onload = function(){
            deal = localStorage.Deal;
            if(deal){
                deal = JSON.parse(deal);
                LoadDeal();
            }
        }

        function LoadDeal(){
            document.getElementById('titleLi').innerHTML = deal.deal_name;
            document.getElementById('bigimg').src = deal.LinksOfImagesArray[0];
            document.getElementById('title').innerHTML = deal.deal_name;
            document.getElementById('description').innerHTML = deal.deal_description;
            document.getElementById('tscs').innerHTML = deal.deal_tc;
            document.getElementById('comment').innerHTML = "NOTE: " + deal.deal_comment;
            document.getElementById('price').innerHTML = "R" + deal.deal_price;
            GenImgs();
        }

        function GenImgs(){
            let i = 1;
            let html = '';
            deal.LinksOfImagesArray.forEach(imglink => {
                let img = document.createElement('img');
                img.src = imglink;
                img.classList.add("smimgs", "mr-2", "mb-2");
                img.id = 'im' + (i++);
                img.addEventListener('click', ChangeBigImg);
                document.getElementById('smlimgsDiv').append(img);
            });
        }

        function ChangeBigImg(){
            let elem = document.getElementById(event.target.id);
            document.getElementById('bigimg').src = elem.src;
        }

    </script>
</body>
</html>