<?php

class Product {
    public $productid;
    public $prodname;
    public $prodprice;

    public function setProductDetails($id, $name, $price) {
        $this->productid = $id;
        $this->prodname = $name;
        $this->prodprice = $price;
    }

    public function getProductID() {
          return $this->productid;
      }
  
      public function getProductName() {
          return $this->prodname;
      }
  
      public function getProductPrice() {
          return $this->prodprice;
      }

    public function displayProdDetails() {
        echo "Product ID: " . $this->productid . PHP_EOL;
        echo "Product Name: " . $this->prodname . PHP_EOL;
        echo "Product Price: " . $this->prodprice . PHP_EOL;
    }

     
}

class Cart {
    public $products = [];

    public function insert($product) {
        array_push($this->products, $product );
        echo "Product inserted into the cart.\n";
    }

    public function update($productId, $newnmae, $newprice) {
        
        foreach ($this->products as $product) {
            if ($product->productid == $productId) {
                $product->setProductDetails($productId, $newnmae, $newprice);
                echo "Product updated in cart." . PHP_EOL;
                return;
            }
        }
        echo "Product not found in cart." . PHP_EOL;
    }

    public function delete($productId) {
        $indexToDelete = -1;
        foreach ($this->products as $index => $product) {
            if ($product->productid == $productId) {
                $indexToDelete = $index;
                break;
            }
        }

        if ($indexToDelete !== -1) {
            array_splice($this->products, $indexToDelete, 1);
            echo "Product with ID $productId deleted from the cart.\n";
        } else {
            echo "Product with ID $productId not found in the cart.\n";
        }
    }

    public function search($productId) {
        $foundProduct = null;
        $flag = false;
        foreach ($this->products as $product) {
            if ($product->productid == $productId) {
                $foundProduct = $product;
                $flag = true;
                break;
            }
        }

        if ($foundProduct !== null) {
            echo "Product found:\n";
            echo "Product ID: " . $foundProduct->productid . "\n";
            echo "Product Name: " . $foundProduct->prodname . "\n";
            echo "Product Price: " . $foundProduct->prodprice . "\n";
        } else {
            echo "Product with ID $productId not found in the cart.\n";
        }
      return $flag;
    }

    public function sortById() {
        usort($this->products, function ($a, $b) {
            return $a->productid - $b->productid;
        });
        echo "Cart sorted by Product ID.\n";
    }

    public function reverseSortById() {
        usort($this->products, function ($a, $b) {
            return $b->productid - $a->productid;
        });
        echo "Cart reverse sorted by Product ID.\n";
    }

    public function displayCart() {
        if (empty($this->products)) {
            echo "Cart is empty.\n";
        } else {
            
            foreach ($this->products as $prod) {
                echo "Cart contents:\n";
                echo "Product ID: " . $prod['productId'] . ", Product Name: " . $prod['productName'] . ", Product Price: " . $prod['productPrice'] . "\n";
            }
        }
      // echo $this->products;
    }
}


$cart = new Cart();
do {
    echo "Choose an operation:\n";
    echo "1. Add product\n";
    echo "2. Update product\n";
    echo "3. Delete product\n";
    echo "4. Search product\n";
    echo "5. Sort by product ID\n";
    echo "6. Reverse sort by product ID\n";
    echo "7. Display cart\n";
    echo "8. Exit\n";
    echo "Enter your choice: ";

    $choice = readline();

    switch ($choice) {
        case 1:
            // Add product
            echo "Enter product details:\n";
            echo "Product ID: ";
            $productid = readline();
            echo "Product Name: ";
            $prodname = readline();
            echo "Product Price: ";
            $prodprice = readline();

            $product = new Product();
            $product->setProductDetails(
                $productid, $prodname, $prodprice
            );
            $cart->insert($product);
            break;

        case 2:
            // Update product
            echo "Enter product ID to update: ";
            $product_id = readline();
            // $productid = intval($product_id);
            // echo gettype($productid);
            
            $product = $cart->search($productid);
            if ($product) {
                echo "Enter new product details:\n";
                echo "Product Name: ";
                $prodname = readline();
                echo "Product Price: ";
                $prodprice = readline();

                
                $cart->update($productid, $prodname, $prodprice);
                echo "Product updated successfully.\n";
            } else {
                echo "Product not found.\n";
            }
            break;

        case 3:
            // Delete product
            echo "Enter product ID to delete: ";
            $productid = readline();

            $cart->delete($productid);
            echo "Product deleted successfully.\n";
            break;

        case 4:
            // Search product
            echo "Enter product ID to search: ";
            $productid = readline();

            $product = $cart->search($productid);
            
            break;

        case 5:
            // Sort by product ID
            $cart->sortById();
            echo "Products sorted by product ID.\n";
            break;

        case 6:
            // Reverse sort by product ID
            $cart->reverseSortById();
            echo "Products reversed by product ID.\n";
            break;

        case 7:
            // Display cart
            echo "Cart contents:\n";
            foreach ($cart->products as $product) {
                $product->displayProdDetails();
            }
            break;

        case 8:
            // Exit the loop
            echo "Exiting.\n";
            break;

        default:
            echo "Invalid choice. Please try again.\n";
            break;
    }
} while ($choice != 8);