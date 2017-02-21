<?php
include_once './help_functions.php';

class SimilarCases
{

    public static function convertDate($id)
    {
        $db = new Database();
        $q = "SELECT * FROM `adss`.`anion_gap` where id=" . $id . " ORDER BY `anion_gap`.`Date.Time` ASC";
        $result = $db->createQuery($q);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public static function getMaxId()
    {
        $db = new Database();
        $q = "SELECT * FROM `adss`.`anion_gap` group by id order by id DESC limit 1";
        $result = $db->createQuery($q);
        return $result;
    }

    public static function getMaxDateCountFromAllTables()
    {
        $db = new Database();
        // From anion
        $q = "SELECT count(*) as max_rows FROM `anion_gap` GROUP BY `id` order by max_rows DESC limit 1";
        $result = $db->createQuery($q);
        $current_max = $result[0]['max_rows'];
        return $current_max;
    }

    public static function KNN_Algorithm($filename, $id, $num_of_neighbors) {
        // Read the csv file that contains patients parameters
        $data = array();
        $file = fopen($filename, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            $data[$line[0]] = $line;
        }
        fclose($file);
        unset($data[0]); // Remove params header (i.e: age,id,bp...)

        // Build distance matrix
        $distances = array();
        $distances[$id] = SimilarCases::euclideanDistance($data[$id], $id, $data);
        // Example, target = id 1, getting 10 nearest neighbors
        $neighbors = SimilarCases::getNearestNeighbors($distances, $id, $num_of_neighbors);
        return $neighbors;
    }

    /**
     * Calculates eucilean distances for an array dataset
     *
     * @param array $sourceCoords In format array(x, y, ...)
     * @param array $sourceKey Associated array key
     * @param array $data
     * @return array Of distances to the rest of the data set
     */
    static function euclideanDistance($sourceCoords, $sourceKey, $data)
    {
        $distances = array();
        $params_size = sizeof($sourceCoords)-1;
        for($i = 1; $i <= $params_size; $i++) {
            ${'x'.$i} = $sourceCoords[$i];
        }
        foreach ($data as $destinationKey => $destinationCoords) {
            // Same point, ignore
            if ($sourceKey == $destinationKey) {
                continue;
            }
            $sum = 0;
            for($i = 1; $i <= $params_size; $i++) {
                ${'y'.$i} = $destinationCoords[$i];
                $sum += (pow((${'x'.$i} - ${'y'.$i}), 2));
            }
            $distances[$destinationKey] = sqrt($sum);
        }
        asort($distances);
        $sourceCoords = $distances;
        return $sourceCoords;
    }

    /**
     * Returns n-nearest neighbors
     *
     * @param array $distances Distances generated above ^
     * @param mixed $key Array key of source location
     * @param int $num Of neighbors to fetch
     * @return array Of nearest neighbors
     */
    static function getNearestNeighbors($distances, $key, $num)
    {
        return array_slice($distances[$key], 0, $num, true);
    }

}