<?php

// to get the restaurant by calling the Mega Table
// for project 2 part 2
// If the all the variables are set when the Submit button is clicked...
if (isset($_POST['field_submit'])) {
    // Refer to conn.php file and open a connection.
    require_once("p2conn.php");
    // Will get the value typed in the form text field and save into variable
    $var_restaurant_name = $_POST['field_restaurant_name'];
    // Save the query into variable called $query. Note that :ph_restaurant_name is a place holder
    $query = "SELECT * FROM mega_table WHERE restaurant_name = :ph_restaurant_name";

try
    {
      // Create a prepared statement. Prepared statements are a way to eliminate SQL INJECTION.
      $prepared_stmt = $dbo->prepare($query);
      //bind the value saved in the variable $var_restaurant_name to the place holder :ph_restaurant_name
      // Use PDO::PARAM_STR to sanitize user string.
      $prepared_stmt->bindValue(':ph_restaurant_name', $var_restaurant_name, PDO::PARAM_STR);
      $prepared_stmt->execute();
      // Fetch all the values based on query and save that to variable $result
      $result = $prepared_stmt->fetchAll();

    }
    catch (PDOException $ex)
    { // Error in database processing.
      echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }
}
?>

<html>
<!-- Any thing inside the HEAD tags are not visible on page.-->
  <head>
    <!-- THe following is the stylesheet file. The CSS file decides look and feel -->
    <link rel="stylesheet" type="text/css" href="project.css" />
  </head> 
<!-- Everything inside the BODY tags are visible on page.-->
  <body>
    <div id="navbar">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="getRestaurant.php">Search Movie</a></li>
        <li><a href="insertRestaurant.php">Insert Movie</a></li>
        <li><a href="deleteRestaurant.php">Delete Movie</a></li>
        <li><a href="getByVegFriendly.php">Delete Restaurant</a></li>
        <li><a href="getByRating5.php">Delete Restaurant</a></li>
        <li><a href="getByGenInfo.php">Delete Restaurant</a></li>
      </ul>
    </div>
    
    <h1> Search Restaurant Info by Restaurant Name</h1>
    <!-- This is the start of the form. This form has one text field and one button.
      See the project.css file to note how form is stylized.-->
    <form method="post">

      <label for="restaurant_link">Restaurant</label>
      <!-- The input type is a text field. Note the name and id. The name attribute
        is referred above on line 7. $var_director = $_POST['field_director']; id attribute is referred in label tag above on line 52-->
      <input type="text" name="field_restaurant_name" id = "id_restaurant_name">
      <!-- The input type is a submit button. Note the name and value. The value attribute decides what will be dispalyed on Button. In this case the button shows Submit.
      The name attribute is referred  on line 3 and line 61. -->
      <input type="submit" name="field_submit" value="Submit">
    </form>
    
    <?php
      if (isset($_POST['field_submit'])) {
        // If the query executed (result is true) and the row count returned from the query is greater than 0 then...
        if ($result && $prepared_stmt->rowCount() > 0) { ?>
              <!-- first show the header RESULT -->
              <h2>Results</h2>
              <!-- THen create a table like structure. See the project.css how table is stylized. -->
              <table>
                <!-- Create the first row of table as table head (thead). -->
                <thead>
                   <!-- The top row is table head with four columns named -- ID, Title ... -->
                  <tr>
                    <th>restaurant_name</th>
                    <th>restaurant_link</th>
                    <th>original_location</th>
                    <th>address</th>
                    <th>city</th>
                    <th>province</th>
                    <th>region</th>
                    <th>country</th>
                  </tr>
                </thead>
                 <!-- Create rest of the the body of the table -->
                <tbody>
                   <!-- For each row saved in the $result variable ... -->
                  <?php foreach ($result as $row) { ?>
                
                    <tr>
                       <!-- Print (echo) the value of restaurant_name in first column of table -->
                      <td><?php echo $row["restaurant_name"]; ?></td>
                      <!-- Print (echo) the value of restaurant_link in second column of table -->
                      <td><?php echo $row["restaurant_link"]; ?></td>
                      <!-- Print (echo) the value of original_location in third column of table -->
                      <td><?php echo $row["location"]; ?></td>

                      <td><?php echo $row["address"]; ?></td>

                      <td><?php echo $row["city"]; ?></td>

                      <td><?php echo $row["province"]; ?></td>

                      <td><?php echo $row["region"]; ?></td>

                       <td><?php echo $row["country"]; ?></td>
                    <!-- End first row. Note this will repeat for each row in the $result variable-->
                    </tr>
                  <?php } ?>
                  <!-- End table body -->
                </tbody>
                <!-- End table -->
            </table>
  
        <?php } else { ?>
          <!-- IF query execution resulted in error display the following message-->
          <h3>Sorry, no results found for the restaurant <?php echo $_POST['field_restaurant_name']; ?>. </h3>
        <?php }
    } ?>


    
  </body>
</html>






