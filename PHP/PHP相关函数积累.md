1. hash_equals — 可防止时序攻击的字符串比较

   ```php
   hash_equals ( string $known_string, string $user_string ) : bool
   ```

   比较两个字符串，无论它们是否相等，本函数的时间消耗是恒定的。

2. 表达式` n&1` 与 表达式`n%2`都能判断n是为奇数还是偶数

3. `array_diff_assoc()`— 带索引检查计算数组的差集

   键值对 *key => value* 中的两个值仅在 *(string) $elem1 === (string) $elem2* 时被认为相等。也就是说使用了严格检查，字符串的表达必须相同。

   > 范例：
   >
   > ```php
   > $array1 = array(0, 1, 2);
   > $array2 = array("00", "01", "2");
   > $result = array_diff_assoc($array1, $array2);
   > print_r($result);
   > // 结果： [0,1]
   > ```
   >
   > 

4. **[二维数组根据某个字段排序](https://www.cnblogs.com/dcb3688/p/4608004.html)**

   *示例一：*

   ```php
   function arraySort($array,$keys,$sort='asc') {
       $newArr = $valArr = array();
       foreach ($array as $key=>$value) {
           $valArr[$key] = $value[$keys];
       }
       ($sort == 'asc') ?  asort($valArr) : arsort($valArr);
       reset($valArr);
       foreach($valArr as $key=>$value) {
           $newArr[$key] = $array[$key];
       }
       return $newArr;
   }
   ```

   *示例二：*

   ```php
   $data[] = array('customer_name' => '小李', 'money' => 12, 'distance' => 2, 'address' => '长安街C坊');
   $data[] = array('customer_name' => '王晓', 'money' => 30, 'distance' => 10, 'address' => '北大街30号');
   $data[] = array('customer_name' => '赵小雅', 'money' => 89, 'distance' => 6, 'address' => '解放路恒基大厦A座');
   $data[] = array('customer_name' => '小月', 'money' => 150, 'distance' => 5, 'address' => '天桥十字东400米');
   $data[] = array('customer_name' => '李亮亮', 'money' => 45, 'distance' => 26, 'address' => '天山西路198弄');
   $data[] = array('customer_name' => '董娟', 'money' => 67, 'distance' => 17, 'address' => '新大南路2号');
   
   // 取得列的列表
   foreach ($data as $key => $row) {
       $distance[$key] = $row['distance'];
       $money[$key] = $row['money'];
   }
   array_multisort($distance, SORT_DESC, $data);
   ```

   *示例三：*

   ```php
   /**
    * 二维数组根据某个字段排序
    * @param array $array 要排序的数组
    * @param string $keys   要排序的键字段
    * @param string $sort  排序类型  SORT_ASC     SORT_DESC 
    * @return array 排序后的数组
    */
   function arraySort($array, $keys, $sort = SORT_DESC) {
       $keysValue = [];
       foreach ($array as $k => $v) {
           $keysValue[$k] = $v[$keys];
       }
       array_multisort($keysValue, $sort, $array);
       return $array;
   }
   ```

   *示例四：*

   ```php
    usort($array, function ($a, $b) {
               if ($a['useCount'] == $b['useCount']) return 0;
               return ($a['useCount'] < $b['useCount']) ? -1 : 1;
           });
   
   // PHP7:
   usort($array, function ($a, $b) {
           return $a['useCount'] <=> $b['useCount'];
   });
   ```

   

5. 

