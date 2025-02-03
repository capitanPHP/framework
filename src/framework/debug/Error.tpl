<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capitan</title>
    <style>body{margin:1em 0;font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:1rem;font-weight:400;line-height:1.5;color:#212529;background-color:#f8f8f8;-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:rgba(0,0,0,0)}.containerStyle,.error-body .error>.header>.top,.error-body .error>.header>.error-message>.boxs,.error-body .error>.header>.error-file,.error-body .error>.header>.ra{padding-left:1em;padding-right:1em;border-radius:10px;-moz-border-radius:10px;-webkit-border-radius:10px;-khtml-border-radius:10px;-o-border-radius:10px;box-shadow:0 10px 13px 0 #ccc;-moz-box-shadow:0 10px 13px 0 #ccc;-webkit-box-shadow:0 10px 13px 0 #ccc;-o-transition:0 10px 13px 0 #ccc}.tagStyle,.error-body .error>.header>.error-message>.boxs>.tag,.error-body .error>.header>.error-file>.boxs>.error-file-list>.tag{display:inline-block;padding:.5em 1em;border-radius:90px;-moz-border-radius:90px;-webkit-border-radius:90px;-khtml-border-radius:90px;-o-border-radius:90px}.error-body{display:flex;justify-content:center}.error-body .error{width:80vw;height:auto}.error-body .error>.header{width:100%}.error-body .error>.header>.top{padding-top:3em;padding-bottom:3.999em;background-color:white;display:flex;justify-content:space-between}.error-body .error>.header>.top>.l>.title{font-size:2rem;line-height:1}.error-body .error>.header>.top>.l>p{color:#999;line-height:0;font-size:.9rem}.error-body .error>.header>.top>.r>p{color:#12569e;line-height:.1;padding:.2em 0;font-size:.9rem}.error-body .error>.header>.error-message{width:96%;height:auto;margin-top:-3em;display:flex;justify-self:center}.error-body .error>.header>.error-message>.boxs{width:100%;padding-top:2em;padding-bottom:2em;background-color:#8d1716}.error-body .error>.header>.error-message>.boxs>.tag{color:white;margin-bottom:1em;background-color:rgba(255,255,255,0.3)}.error-body .error>.header>.error-message>.boxs>.message{color:white;font-size:1.3rem;display:block;padding-left:.8em}.error-body .error>.header>.error-file{height:720px;background-color:white;margin-top:-3em;padding-top:5em;padding-bottom:3em;display:flex;justify-content:center}.error-body .error>.header>.error-file>.boxs{width:96%}.error-body .error>.header>.error-file>.boxs>.error-file-list{display:flex;justify-self:start}.error-body .error>.header>.error-file>.boxs>.error-file-list>.tag{color:#8d1716;margin-bottom:1em;background-color:rgba(141,23,22,0.1)}.error-body .error>.header>.error-file>.boxs>.error-file-list>.active-file{color:#12569e;padding:.5em 1em}.error-body .error>.header>.error-file>.boxs>.error-file-list>.active-file>code{color:#8d1716;padding:.1em .3em;background-color:rgba(141,23,22,0.1);border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;-khtml-border-radius:3px;-o-border-radius:3px}.error-body .error>.header>.error-file>.boxs>.error-file-list>.file-list{display:none}.error-body .error>.header>.error-file>.boxs>.file-content{width:100%;height:calc(720px - 7em);border:1px solid #d9d9d9;border-radius:6px;-moz-border-radius:6px;-webkit-border-radius:6px;-khtml-border-radius:6px;-o-border-radius:6px}.error-body .error>.header>.error-file>.boxs>.file-content>.codebox{margin:1em}.error-body .error>.header>.ra{height:auto;background-color:white;margin-top:-3em;padding-top:7em;padding-bottom:3.999em;position:relative;z-index:-1}.error-body .error>.header>.ra>.boxs{display:flex;justify-content:space-between}.error-body .error>.header>.ra>.boxs dl>dt,.error-body .error>.header>.ra>.boxs dl>dd{margin:0}.error-body .error>.header>.ra>.boxs dl>dt{font-size:2rem}.error-body .error>.header>.ra>.boxs dl>dd{color:#999;font-size:.8rem}.error-body .error>.header>.ra>.boxs>.req,.error-body .error>.header>.ra>.boxs>.app{width:calc(100%/2);padding:0 1.7em}.error-body .error>.header>.ra>.boxs>.req>b,.error-body .error>.header>.ra>.boxs>.app>b{display:block;margin:2em 0 .5em 0}.error-body .error>.header>.ra>.boxs>.req>table,.error-body .error>.header>.ra>.boxs>.app>table{width:100%;table-layout:fixed;border-collapse:collapse}.error-body .error>.header>.ra>.boxs>.req>table tbody,.error-body .error>.header>.ra>.boxs>.app>table tbody{border:1px solid #d9d9d9}.error-body .error>.header>.ra>.boxs>.req>table tbody tr,.error-body .error>.header>.ra>.boxs>.app>table tbody tr{display:table-row;vertical-align:inherit}.error-body .error>.header>.ra>.boxs>.req>table tbody tr td,.error-body .error>.header>.ra>.boxs>.app>table tbody tr td{font-size:.9rem;padding:.3em 1em;text-align:left;border:1px solid #d9d9d9;word-wrap:break-word;overflow-wrap:break-word}.error-body .error>.header>.ra>.boxs>.req>table tbody tr td:first-child,.error-body .error>.header>.ra>.boxs>.app>table tbody tr td:first-child{width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.error-body .error>.header>.ra>.boxs>.req>pre,.error-body .error>.header>.ra>.boxs>.app>pre{margin:0;padding:1em;border:1px solid #d9d9d9;font-size:.9rem}</style>
    <script></script>
</head>
<body>
    <div class="error-body">
        <div class="error">
            <div class="header">
                <div class="top">
                    <div class="l">
                        <div class="title">Internal Server Error</div>
                        <p>GET <%= HTTP_HOST %></p>
                    </div>
                    <div class="r">
                        <p>PHP <%= phpversion %></p>
                        <p>Capitan <%= capitanversion %></p>
                    </div>
                </div>
                <div class="error-message">
                    <div class="boxs">
                        <div class="tag"><b>Type Error</b></div>
                        <div class="message"><%= message %></div>
                    </div>
                </div>
                <div class="error-file">
                    <div class="boxs">
                        <div class="error-file-list">
                            <div class="tag"><b>Type File</b></div>
                            <div class="active-file"><%= file %>:<%= line %> <code><%= action %></code></div>
                            <div class="file-list"></div>
                        </div>
                        
                        <div class="file-content">
                            <div class="codebox">123</div>
                        </div>
                    </div>
                </div>
                <div class="ra">
                    <div class="boxs">
                        <div class="req">
                            <dl>
                                <dt>Request</dt>
                                <dd>GET /tests</dd>
                            </dl>
                            <b>Headers</b>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Cookie</td>
                                        <td><%= Cookie %></td>
                                    </tr>
                                    <tr>
                                        <td>ACCEPT</td>
                                        <td><%= HTTP_ACCEPT %></td>
                                    </tr>
                                    <tr>
                                        <td>ACCEPT_LANGUAGE</td>
                                        <td><%= HTTP_ACCEPT_LANGUAGE %></td>
                                    </tr>
                                    <tr>
                                        <td>ACCEPT_ENCODING</td>
                                        <td><%= HTTP_ACCEPT_ENCODING %></td>
                                    </tr>
                                    <tr>
                                        <td>USER_AGENT</td>
                                        <td><%= HTTP_USER_AGENT %></td>
                                    </tr>
                                    <tr>
                                        <td>UPGRADE_INSECURE_REQUESTS</td>
                                        <td><%= HTTP_UPGRADE_INSECURE_REQUESTS %></td>
                                    </tr>
                                    <tr>
                                        <td>CACHE_CONTROL</td>
                                        <td><%= HTTP_CACHE_CONTROL %></td>
                                    </tr>
                                    <tr>
                                        <td>CONNECTION</td>
                                        <td><%= HTTP_CONNECTION %></td>
                                    </tr>
                                    <tr>
                                        <td>HOST</td>
                                        <td><%= HTTP_HOST %></td>
                                    </tr>
                                </tbody>
                            </table>
                            <b>Body</b>
<pre><code><%= Body %></code></pre>
                        </div>
                        <div class="app">
                            <dl>
                                <dt>Main</dt>
                                <dd>Event 0</dd>
                            </dl>
                            <b>Routing</b>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>controller</td>
                                        <td>App\Http\Controllers\Test@show</td>
                                    </tr>
                                    <tr>
                                        <td>middleware</td>
                                        <td>web</td>
                                    </tr>
                                </tbody>
                            </table>
                            <b>Database Queries</b>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>sqlite <small>(0.27 ms)</small></td>
                                        <td>select * from "sessions" where "id" = 'rhGHHqlZq4ag7lKrxk8s77i6NM6lSHwu2DiJuZAJ' limit 1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</body>
</html>