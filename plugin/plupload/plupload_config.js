/**
全局的配置参数
一般还有部分局部参数需要自行配置
<script>
global_config.browse_button = 'browse';
global_config.url = '';
global_config.flash_swf_url = 'js/Moxie.swf';
global_config.silverlight_xap_url = 'js/Moxie.xap';
</script>
 */


var plupload_config = {
    
    //触发文件选择对话框的DOM元素，当点击该元素后便后弹出文件选择对话框。该值可以是DOM元素对象本身，也可以是该DOM元素的id
    browse_button : '',  
    
    //服务器端接收和处理上传文件的脚本地址，可以是相对路径(相对于当前调用Plupload的文档)，也可以是绝对路径
    url : '',
    
    //flash上传组件的url地址，如果是相对路径，则相对的是调用Plupload的html文档。当使用flash上传方式会用到该参数。
    flash_swf_url:'js/Moxie.swf',
    
    //silverlight上传组件的url地址，如果是相对路径，则相对的是调用Plupload的html文档。当使用silverlight上传方式会用到该参数。
    silverlight_xap_url:'js/Moxie.xap',
    
    /*可以使用该参数来限制上传文件的类型，大小等，该参数以对象的形式传入，它包括三个属性：
    mime_types：用来限定上传文件的类型，为一个数组，该数组的每个元素又是一个对象，该对象有title和extensions两个属性，title为该过滤器的名称，extensions为文件扩展名，有多个时用逗号隔开。该属性默认为一个空数组，即不做限制。
    max_file_size：用来限定上传文件的大小，如果文件体积超过了该值，则不能被选取。值可以为一个数字，单位为b,也可以是一个字符串，由数字和单位组成，如'200kb'
    prevent_duplicates：是否允许选取重复的文件，为true时表示不允许，为false时表示允许，默认为false。如果两个文件的文件名和大小都相同，则会被认为是重复的文件
    只允许上传ZIP和图片的配置如下(当然也可以只配置其中的某一项)：*/
    filters : {
        mime_types : [
            { title : "imageFiles", extensions : "jpg,gif,png" },
            { title : "zipFiles", extensions : "" }
        ],
        max_file_size : '2GB', //最大只能上传2MB的文件
        prevent_duplicates : true //不允许选取重复文件
    },
    
    //上传时的附加参数，以键/值对的形式传入，服务器端可是使用$_POST来获取这些参数
    multipart_params: {},
    
    /*指定了使用拖拽方式来选择上传文件时的拖拽区域，即可以把文件拖拽到这个区域的方式来选择文件。
    该参数的值可以为一个DOM元素的id,也可是DOM元素本身，还可以是一个包括多个DOM元素的数组。
    如果不设置该参数则拖拽上传功能不可用。目前只有html5上传方式才支持拖拽上传。*/
    drop_element:'plupload',
    
    //当发生plupload.HTTP_ERROR错误时的重试次数，为0时表示不重试
    max_retries : 2,
    
    //为true时将以multipart/form-data的形式来上传文件，为false时则以二进制的格式来上传文件。
    //html4上传方式不支持以二进制格式来上传文件，在flash上传方式中，二进制上传也有点问题。
    //并且二进制格式上传还需要在服务器端做特殊的处理。一般我们用multipart/form-data的形式来上传文件就足够了。
    multipart :true,
    
    //分片上传文件时，每片文件被切割成的大小，为数字时单位为字节。也可以使用一个带单位的字符串，如"200kb"。当该值为0时表示不使用分片上传功能
    chunk_size:'1MB',
    
    //是否可以在文件浏览对话框中选择多个文件，true为可以，false为不可以。默认true，即可以选择多个文件。
    multi_selection:true,
    
    //当值为true时会为每个上传的文件生成一个唯一的文件名，并作为额外的参数post到服务器端，参数明为name,值为生成的文件名。
    unique_names:false,
    
    /*用来指定上传方式，指定多个上传方式请使用逗号隔开。
     * 一般情况下，你不需要配置该参数，因为Plupload默认会根据你的其他的参数配置来选择最合适的上传方式。
     * 如果没有特殊要求的话，Plupload会首先选择html5上传方式，如果浏览器不支持html5，则会使用flash或silverlight，如果前面两者也都不支持，则会使用最传统的html4上传方式。
     * 如果你想指定使用某个上传方式，或改变上传方式的优先顺序，则你可以配置该参数。*/
    runtimes:'html5,html4,flash,silverlight',
    
    //指定文件上传时文件域的名称，默认为file,例如在php中你可以使用$_FILES['file']来获取上传的文件信息
    file_data_name:'plupload_files'
    
    //用来指定Plupload所创建的html结构的父容器，默认为前面指定的browse_button的父元素。该参数的值可以是一个元素的id,也可以是DOM元素本身。
    //container:''

}