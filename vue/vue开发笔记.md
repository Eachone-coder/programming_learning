#### 2019年9月16日vue开发笔记

1. vue模板引用问题

   vue报错Component template should contain exactly one root element. If you are using v-if on multiple elements, use v-else-if to chain them instead. 如下图：

   ![](E:\github\aboutMe\image\Snipaste_2019-09-16_16-09-02.png)

   原因及解决办法：vue模板只支持一个元素，不能并列包含两个及以上。一个组件渲染过程中包含了另外一个组件，如果需要，需要在外面套一层比如div即可。如下图：

   ![](E:\github\aboutMe\image\Snipaste_2019-09-16_16-13-32.png)

   去掉外层的div就会报错了，加上就正常。

2. vue中组件所引用的样式文件是以本身组件所在路径引用的，不是以最终调用组件的路径引用的

3. 在父子组件传值的时候，子组件绑定img标签src值。示例： 子组件接收值

   ```vue
   <template>
       <img :src="getImage" />
   </template>
   <script>
   export default {
     name:'myChart',
     props:['chartInfo'],
     computed:{
         getImage(){
           return require(`../assets/images/${this.chartInfo.chartImg}`)
         }
     }
   }
   </script>
   ```

4. 这是啥子？

   ```vue
   Promise.all([this._initWinning()])
                       .then(res => {
                           this.$message({
                               message: "已更新为最新数据",
                               type: "success"
                           });
                       })
                       .catch(res => {
                           this.$message({
                               message: "刷新失败，请重试",
                               type: "error"
                           });
                       });
   ```

5. `v-show`和`v-if`的使用

   > `v-if`适合运营条件不大可能改变；`v-show`适合频繁切换。
   > （1）对于管理系统的权限列表的展示，这里可以使用`v-if`来渲染，如果使用到`v-show`，对于用户没有的权限，在网页的源码中，仍然能够显示出该权限，如果用v-if，网页的源码中就不会显示出该权限。（在前后台分离情况下，后台不负责渲染页面的场景。）
   > （2）对于前台页面的数据展示，这里推荐使用`v-show`，这样可以减少开发中不必要的麻烦。
   >
   > 
   >
   > `v-if`和`v-show`都是用来控制元素的渲染。`v-if`判断是否加载，可以减轻服务器的压力，在需要时加载,但有更高的切换开销;v-show调整DOM元素的CSS的dispaly属性，可以使客户端操作更加流畅，但有更高的初始渲染开销。如果需要非常频繁地切换，则使用` v-show`较好；如果在运行时条件很少改变，则使用 `v-if` 较好。
   >
   > 

6. **vue动态绑定class**

   [参考链接](https://cn.vuejs.org/v2/guide/class-and-style.html)☜☜☜

   - *string:*

     ```vue
     <!-- HTML代码 -->
     <div :class=" 'classA classB' ">Demo1</div>
     
     <!-- 渲染后的HTML -->
     <div class="classA classB">Demo1</div>
     ```

   - *数据变量:*

     ```vue
     <!-- HTML代码 -->
     <div :class="classA">Demo2</div>
     
     <!-- javascript -->
     data: {
       classA: 'class-a'  //当classA改变时将更新class
     }
     
     <!-- 渲染后的HTML -->
     <div class="class-a">Demo2</div>
     ```

     写在指令中的值会被视作表达式，如javascript表达式，因此v-bind:class接受三目运算：

     ```vue
     <!-- HTML代码 -->
     <div :class="classA ? 'class-a' : 'class-b' ">Demo3</div>
     
     <!-- 渲染后的HTML -->
     <div class="class-a">Demo3</div>
     ```

   - *对象:*

     ```vue
     <!-- HTML代码 -->
     <div :class="{ 'class-a': isA, 'class-b': isB}">Demo4</div>
     
     <!-- javascript -->
     data: {
       isA: false,  //当isA改变时，将更新class
       isB: true    //当isB改变时，将更新class
     }
     
     <!-- 渲染后的HTML -->
     <div class="class-b">Demo4</div>
     
     ---------------------------------------------------------------------------------------------
     
     <!-- HTML代码 -->
     <div :class="objectClass">Demo5</div>
     
     <!-- javascript -->
     data: {
       objectClass: {
         class-a: true,
         class-b: false
       }
     }
     
     <!-- 渲染后的HTML -->
     <div class="class-a">Demo5</div>
     ```

   - *数组:*

     ```vue
     <!-- HTML代码 -->
     <div :class="[classA, classB]">Demo6</div>
     
     <!-- javascript -->
     data: {
       classA: 'class-a',
       classB: 'class-b'
     }
     
     <!-- 渲染后的HTML -->
     <div class="class-a class-b">Demo6</div>
     
     ---------------------------------------------------------------------------------------------
     
     <!-- HTML代码 -->
     <div :class="[classA, classB]">Demo7</div>
     
     <!-- javascript -->
     data: {
       classA: 'class-a',
       objectClass: {
         classB: 'class-b',  // classB 的值为class-b, 则将classB的值添加到class列表
         classC: false,    // classC值为false,将不添加classC
         classD: true    // classD 值为true，classC将被直接添加到class列表
     }
     }
     
     <!-- 渲染后的HTML -->
     <div class="class-a class-b classD">Demo7</div>
     ```

     我自己写的一个：

     ```vue
     <el-button type="primary" 
                icon="el-icon-document-checked"
                :plain="!(currentTable === 'reviewed')"
                :class="['title-check',(currentTable === 'reviewed') ? 'checked' : 'checking']"
                >已审核</el-button>
     ```

7. **click点击事件**

   [参考链接](https://cn.vuejs.org/v2/guide/events.html)☜☜☜

   ```vue
   <!-- HTML代码 -->
   <button v-on:click="warn('Form cannot be submitted yet.', $event)">
     Submit
   </button>
   
   <!-- javascript -->
   // ...
   methods: {
     warn: function (message, event) {
       // 现在我们可以访问原生事件对象
       if (event) event.preventDefault()
       alert(message)
     }
   }
   ```

   `$event`标准属性

   | 属性                                                         | 描述                                           |
   | ------------------------------------------------------------ | ---------------------------------------------- |
   | [bubbles](http://www.w3school.com.cn/jsref/event_bubbles.asp) | 返回布尔值，指示事件是否是起泡事件类型。       |
   | [cancelable](http://www.w3school.com.cn/jsref/event_cancelable.asp) | 返回布尔值，指示事件是否可拥可取消的默认动作。 |
   | [currentTarget](http://www.w3school.com.cn/jsref/event_currenttarget.asp) | **返回其事件监听器触发该事件的元素。**         |
   | [eventPhase](http://www.w3school.com.cn/jsref/event_eventphase.asp) | 返回事件传播的当前阶段。                       |
   | [target](http://www.w3school.com.cn/jsref/event_target.asp)  | **返回触发此事件的元素（事件的目标节点）。**   |
   | [timeStamp](http://www.w3school.com.cn/jsref/event_timestamp.asp) | 返回事件生成的日期和时间。                     |
   | [type](http://www.w3school.com.cn/jsref/event_type.asp)      | 返回当前 Event 对象表示的事件的名称。          |

8. **`Array filter()`的使用**

   [参考链接](https://juejin.im/post/5a5f3eaf518825733201a6a7)☜☜☜

   [MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/filter)☜☜☜

   `filter()` 方法创建一个新的数组，新数组中的元素是通过检查指定数组中符合条件的所有元素。

   ```vue
   let ages = [32, 33, 16, 40];
   let newAges = ages.filter(item => item > 18);
   console.log(newAges);   // [32, 33, 40]
   ```

9. `v-model`

   [参考链接](https://cythilya.github.io/2017/04/14/vue-data-v-model/)☜☜☜

10. **vue的Element UI 表格点击选中行/取消选中 快捷多选 以及快捷连续多选，高亮选中行**

    [参考链接 ](https://juejin.im/post/5d5030e4e51d4561e224a2fb)☜☜☜

11. **template中的`slot`语法**

    ```vue
    <template slot-scope="scope">{{scope.$index+(data.currentPage-1)*data.pageSize+1}}</template>
    ```

    

12. **父子组件之间的双向传值**

    [参考链接](https://cn.vuejs.org/v2/guide/components-props.html)☜☜☜

    双向传值规则为：`props down , events up`，即 prop 向下传递，事件向上传递。父组件通过 prop 给子组件下发数据，子组件通过事件给父组件发送消息，如下图所示：

    <img src="..\image\20180110222712301.png" style="zoom:20%;" />

    

13. **vuex**

    

14. 

