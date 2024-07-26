@extends('admin.layouts.app')
@section('content')
<!-- Content Wrapper START -->
<div class="main-content">
    <div class="page-header">
        <h2 class="header-title">Form Elements</h2>
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                <a class="breadcrumb-item" href="#">Forms</a>
                <span class="breadcrumb-item active">Form Elements</span>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Basic Input</h4>
            <p>Included <code>.form-control</code> to <code>&lt;input&gt;</code>, <code>&lt;select&gt;</code>s and <code>&lt;textarea&gt;</code>for general appearance, focus state, sizing, and more.</p>
            <div class="m-t-25">
                <dic class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control m-b-15" placeholder="Basic Input">
                        <input type="text" class="form-control" placeholder="Disabled Input" disabled="">
                    </div>
                </dic>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup"><script type="text/plain"><input type="text" class="form-control" placeholder="Basic Input">
<input type="text" class="form-control" placeholder="Disabled Input" disabled=""></script></code></pre>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Input Sizing</h4>
            <p>Set heights using classes like <code>.form-control-lg</code> and <code>.form-control-sm</code>.</p>
            <div class="m-t-25">
                <div class="row">
                    <div class="col-md-4">
                        <input class="form-control form-control-lg m-b-10" type="text" placeholder=".form-control-lg">
                        <input class="form-control m-b-10" type="text" placeholder="Default input">
                        <input class="form-control form-control-sm" type="text" placeholder=".form-control-sm">
                    </div>
                </div>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup"><script type="text/plain"><input class="form-control form-control-lg" type="text" placeholder=".form-control-lg">
<input class="form-control" type="text" placeholder="Default input">
<input class="form-control form-control-sm" type="text" placeholder=".form-control-sm"></script></code></pre>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Input Group</h4>
            <p>Place one add-on or button on either side of an input. You may also place one on both sides of an input. Remember to place <code>&lt;label&gt;</code>s outside the input group.</p>
            <div class="m-t-25">
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">@example.com</span>
                            </div>
                        </div>

                        <label for="basic-url">Your vanity URL</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">https://</span>
                            </div>
                            <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">With textarea</span>
                            </div>
                            <textarea class="form-control" aria-label="With textarea"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup"><script type="text/plain"><div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">@</span>
    </div>
    <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
</div>

<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
    <div class="input-group-append">
        <span class="input-group-text" id="basic-addon2">@example.com</span>
    </div>
</div>

<label for="basic-url">Your vanity URL</label>
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon3">https://</span>
    </div>
    <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
</div>

<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">$</span>
    </div>
    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
    <div class="input-group-append">
        <span class="input-group-text">.00</span>
    </div>
</div>

<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text">With textarea</span>
    </div>
    <textarea class="form-control" aria-label="With textarea"></textarea>
</div></script></code></pre>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Input Group Sizing</h4>
            <p>Add the relative form sizing classes to the <code>.input-group</code> itself and contents within will automatically resize—no need for repeating the form control size classes on each element.</p>
            <p><strong>Sizing on the individual input group elements isn’t supported.</strong></p>
            <div class="m-t-25">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Small</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Default</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        </div>

                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-lg">Large</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                </div>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup"><script type="text/plain"><div class="input-group input-group-sm mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-sm">Small</span>
    </div>
    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
</div>

<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-default">Default</span>
    </div>
    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>

<div class="input-group input-group-lg">
    <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-lg">Large</span>
    </div>
    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
</div></script></code></pre>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Input Affix</h4>
            <p>Add prefix or suffix icons inside input.</p>
            <div class="m-t-25">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-affix m-b-10">
                            <i class="prefix-icon anticon anticon-search"></i>
                            <input type="text" class="form-control" placeholder="Icon Prefix">
                        </div>
                        <div class="input-affix m-b-10">
                            <input type="text" class="form-control" placeholder="Icon Suffix">
                            <i class="suffix-icon anticon anticon-eye"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup"><script type="text/plain"><div class="input-affix m-b-10">
    <i class="prefix-icon anticon anticon-search"></i>
    <input type="text" class="form-control" placeholder="Icon Prefix">
</div>
<div class="input-affix m-b-10">
    <input type="text" class="form-control" placeholder="Icon Suffix">
    <i class="suffix-icon anticon anticon-eye"></i>
</div></script></code></pre>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Checkbox</h4>
            <p>Usage of checkbox.</p>
            <div class="m-t-25">
                <div class="checkbox">
                    <input id="checkbox1" type="checkbox" checked="">
                    <label for="checkbox1">Checked</label>
                </div>
                <div class="checkbox">
                    <input id="checkbox2" type="checkbox">
                    <label for="checkbox2">Uncheck</label>
                </div>
                <div class="checkbox">
                    <input id="checkbox3" type="checkbox" disabled="">
                    <label for="checkbox3">Disabled Unchecked</label>
                </div>
                <div class="checkbox">
                    <input id="checkbox4" type="checkbox" checked="" disabled="">
                    <label for="checkbox4">Disabled Checked</label>
                </div>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup"><script type="text/plain"><div class="checkbox">
    <input id="checkbox1" type="checkbox" checked="">
    <label for="checkbox1">Checked</label>
</div>
<div class="checkbox">
    <input id="checkbox2" type="checkbox">
    <label for="checkbox2">Uncheck</label>
</div>
<div class="checkbox">
    <input id="checkbox3" type="checkbox" disabled="">
    <label for="checkbox3">Disabled Unchecked</label>
</div>
<div class="checkbox">
    <input id="checkbox4" type="checkbox" checked="" disabled="">
    <label for="checkbox4">Disabled Checked</label>
</div></script></code></pre>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Radio</h4>
            <p>Usage of checkbox.</p>
            <div class="m-t-25">
                <div class="radio">
                    <input id="radio1" name="radioDemo" type="radio" checked="">
                    <label for="radio1">Checked</label>
                </div>
                <div class="radio">
                    <input id="radio2" name="radioDemo" type="radio">
                    <label for="radio2">Uncheck</label>
                </div>
                <div class="radio">
                    <input id="radio3" name="radioDemo1" type="radio" disabled="">
                    <label for="radio3">Disabled Unchecked</label>
                </div>
                <div class="radio">
                    <input id="radio4" name="radioDemo1" type="radio" checked="" disabled="">
                    <label for="radio4">Disabled Checked</label>
                </div>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup"><script type="text/plain"><div class="radio">
    <input id="radio1" name="radioDemo" type="radio" checked="">
    <label for="radio1">Checked</label>
</div>
<div class="radio">
    <input id="radio2" name="radioDemo" type="radio">
    <label for="radio2">Uncheck</label>
</div>
<div class="radio">
    <input id="radio3" name="radioDemo1" type="radio" disabled="">
    <label for="radio3">Disabled Unchecked</label>
</div>
<div class="radio">
    <input id="radio4" name="radioDemo1" type="radio" checked="" disabled="">
    <label for="radio4">Disabled Checked</label>
</div></script></code></pre>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Switch</h4>
            <p>Usage of switch.</p>
            <div class="m-t-25">
                <div class="form-group d-flex align-items-center">
                    <div class="switch m-r-10">
                        <input type="checkbox" id="switch-1" checked="">
                        <label for="switch-1"></label>
                    </div>
                    <label>Checked</label>
                </div>
                <div class="form-group d-flex align-items-center">
                    <div class="switch m-r-10">
                        <input type="checkbox" id="switch-2">
                        <label for="switch-2"></label>
                    </div>
                    <label>Uncheck</label>
                </div>
                <div class="form-group d-flex align-items-center">
                    <div class="switch m-r-10">
                        <input type="checkbox" id="switch-3" disabled="">
                        <label for="switch-3"></label>
                    </div>
                    <label>Disabled</label>
                </div>
                <div class="form-group d-flex align-items-center">
                    <div class="switch d-inline m-r-10">
                        <input type="checkbox" id="switch-4" disabled="" checked="">
                        <label for="switch-4"></label>
                    </div>
                    <label>Disabled Checked</label>
                </div>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup"><script type="text/plain"><div class="form-group d-flex align-items-center">
    <div class="switch m-r-10">
        <input type="checkbox" id="switch-1" checked="">
        <label for="switch-1"></label>
    </div>
    <label>Checked</label>
</div>
<div class="form-group d-flex align-items-center">
    <div class="switch m-r-10">
        <input type="checkbox" id="switch-2">
        <label for="switch-2"></label>
    </div>
    <label>Uncheck</label>
</div>
<div class="form-group d-flex align-items-center">
    <div class="switch m-r-10">
        <input type="checkbox" id="switch-3" disabled="">
        <label for="switch-3"></label>
    </div>
    <label>Disabled</label>
</div>
<div class="form-group d-flex align-items-center">
    <div class="switch d-inline m-r-10">
        <input type="checkbox" id="switch-4" disabled="" checked="">
        <label for="switch-4"></label>
    </div>
    <label>Disabled Checked</label>
</div></script></code></pre>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Select2</h4>
            <p>Select2 gives you a customizable select box with support for searching, tagging, remote data sets, infinite scrolling, and many other highly used options. For more usaage information, please refer to <a href="https://select2.org/" target="_blank">Select2</a></p>
            <div class="m-t-25">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Single select boxes -->
                        <div class="m-b-15">
                            <select class="select2" name="state">
                                <option value="AP">Apples</option>
                                <option value="NL">Nails</option>
                                <option value="BN">Bananas</option>
                                <option value="HL">Helicopters</option>
                            </select>
                        </div>
                        <!-- Multiple select boxes -->
                        <div class="m-b-15">
                            <select class="select2" name="states[]" multiple="multiple">
                                <option value="AP">Apples</option>
                                <option value="NL">Nails</option>
                                <option value="BN">Bananas</option>
                                <option value="HL">Helicopters</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup">&lt;!-- page css -->
                                        &lt;link href="/assets/vendors/select2/select2.css" rel="stylesheet">

                                        &lt;!-- page js -->
                                        &lt;script src="/assets/vendors/select2/select2.min.js">&lt;/script></code></pre>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup"><script type="text/plain"><!-- Single select boxes -->
<div class="m-b-15">
    <select class="select2" name="state">
        <option value="AP">Apples</option>
        <option value="NL">Nails</option>
        <option value="BN">Bananas</option>
        <option value="HL">Helicopters</option>
    </select>
</div>

<!-- Multiple select boxes -->
<div>
    <select class="select2" name="states[]" multiple="multiple">
        <option value="AP">Apples</option>
        <option value="NL">Nails</option>
        <option value="BN">Bananas</option>
        <option value="HL">Helicopters</option>
    </select>
</div></script></code></pre>
            </div>
            <div class="code-example">
                <pre><code class="language-js"><script type="text/plain">$('.select2').select2();</script></code></pre>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>File Browser</h4>
            <p>The file input is the most gnarly of the bunch and requires additional JavaScript if you’d like to hook them up with functional Choose file… and selected file name text.</p>
            <div class="m-t-25">
                <div class="row">
                    <div class="col-md-7">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="code-example">
                                    <pre><code class="language-markup"><script type="text/plain"><div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile">
        <label class="custom-file-label" for="customFile">Choose file</label>
    </div></script></code></pre>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Bootstrap-Datepicker</h4>
            <p>Bootstrap-datepicker provides a flexible datepicker widget in the Bootstrap style. For more usaage information, please refer to <a href="https://bootstrap-datepicker.readthedocs.io/en/stable/" target="_blank">bootstrap-datepicker</a></p>
            <div class="m-t-25">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Default Datepicker-->
                        <div class="form-group">
                            <label>Default Datepicker</label>
                            <div class="input-affix m-b-10">
                                <i class="prefix-icon anticon anticon-calendar"></i>
                                <input type="text" class="form-control datepicker-input" placeholder="Pick a date">
                            </div>
                        </div>

                        <!-- Range Datepicker-->
                        <div class="form-group">
                            <label>Range Datepicker</label>
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control datepicker-input" name="start" placeholder="From">
                                <span class="p-h-10">to</span>
                                <input type="text" class="form-control datepicker-input" name="end" placeholder="To">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">

                        <!-- Inline Datepicker-->
                        <label>Inline Date Picker</label>
                        <div data-provide="datepicker-inline"></div>
                    </div>
                </div>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup">&lt;!-- page css -->
                                        &lt;link href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">

                                        &lt;!-- page js -->
                                        &lt;script src="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js">&lt;/script></code></pre>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup"><script type="text/plain"><!-- Default Datepicker-->
<div class="form-group">
    <label>Default Datepicker</label>
    <div class="input-affix m-b-10">
        <i class="prefix-icon anticon anticon-calendar"></i>
        <input type="text" class="form-control datepicker-input" placeholder="Pick a date">
    </div>
</div>

<!-- Range Datepicker-->
<div class="form-group">
    <label>Range Datepicker</label>
    <div class="d-flex align-items-center">
        <input type="text" class="form-control datepicker-input" name="start" placeholder="From">
        <span class="p-h-10">to</span>
        <input type="text" class="form-control datepicker-input" name="end" placeholder="To">
    </div>
</div>

<!-- Inline Datepicker-->
<label>Inline Date Picker</label>
<div data-provide="datepicker-inline"></div></script></code></pre>
            </div>
            <div class="code-example">
                <pre><code class="language-js"><script type="text/plain">$('.datepicker-input').datepicker();</script></code></pre>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Quill Editor</h4>
            <p>Quill is a free, open source WYSIWYG editor built for the modern web. With its modular architecture and expressive API, it is completely customizable to fit any need. For more usaage information, please refer to <a href="https://quilljs.com/docs/quickstart/" target="_blank">Quill</a></p>
            <div class="m-t-25">
                <div id="editor">
                    <p>Hello World!</p>
                    <p>Some initial <strong>bold</strong> text</p>
                    <p><br></p>
                </div>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup">&lt;!-- page js -->
                                        &lt;script src="/assets/vendors/quill/quill.min.js">&lt;/script></code></pre>
            </div>
            <div class="code-example">
                                <pre><code class="language-markup"><script type="text/plain"><div id="editor">
    <p>Hello World!</p>
    <p>Some initial <strong>bold</strong> text</p>
    <p><br></p>
</div></script></code></pre>
            </div>
            <div class="code-example">
                                <pre><code class="language-js"><script type="text/plain">new Quill('#editor', {
    theme: 'snow'
});</script></code></pre>
            </div>
        </div>
    </div>
</div>
<!-- Content Wrapper END -->
@endsection