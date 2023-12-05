<?php
$conn = mysqli_connect("localhost", "root", "nayan", "product");
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "GET":
        if (!empty($_GET["cid"])) {
            $category_id = intval($_GET["cid"]);
            get_Category($category_id);
        } else {
            get_Category();
        }
        break;
    case "POST":
        if (!empty($_GET["cid"])) {
            $category_id = intval($_GET["cid"]);
            update_category($category_id);
        } else {
            insert_category();
        }
        break;
    case "PUT":
        $category_id = intval($_GET["cid"]);
        update_category($category_id);
        break;
    case "DELETE":
        $category_id = intval($_GET["cid"]);
        delete_category($category_id);
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_Category($category_id = 0)
{
    global $conn;
    $query = "SELECT * FROM category";
    if ($category_id != 0) {
        $query .= "WHERE cid=" . $category_id;
    }
    $response = array();
    $result = mysqli_query($conn, $query);
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
    header("Content-Type: application/json");
    echo json_encode($response);
}

function insert_category()
{
    global $conn;
    if (isset($_POST["cname"])) {
        $category_name = $_POST["cname"];
        $query = "INSERT INTO category SET name='{$category_name}'";
        if (mysqli_query($conn, $query)) {
            $response = array(
                'status' => 1,
                'status_mesager' => 'Category inserted'
            );
        } else {
            $response = array(
                'status' => 0,
                'status_mesager' => 'Category not inserted'
            );
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    } else {
        echo "please enter category name";
    }
}

function update_category($category_id)
{
    global $conn;
    if (isset($_POST["name"])) {
        $category_name = $_POST["name"];
        $query = "UPDATE category SET name='{$category_name}' WHERE id=" . $category_id;

        if (mysqli_query($conn, $query)) {
            $response = array(
                'status' => 1,
                'status_message' => 'Category updated successfully'
            );
        } else {
            $response = array(
                'status' => 0,
                'status_message' => 'Category not upadte'
            );
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    } else {
        echo "please enter category name";
    }
}

function delete_category($category_id)
{
    global $conn;
    $query = "DELETE FROM category WHERE id=" . $category_id;
    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Category deleted successfully'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Category not delete'
        );
    }
    header("Content-Type: application/json");
    echo json_encode($response);
}

mysqli_close($conn);
