<div class="col-sm-12" style="border-bottom: 1px solid #ccc; border-bottom-left-radius: 0; border-bottom-right-radius: 0; margin-bottom: 20px; padding-bottom: 30px;">
    <form class="form-inline" action="{{ request()->getRequestUri() }}" method="GET" name="myForm" id="myForm">
        <div style="display: inline-block;">
            <select name="order-by" class="form-control" style="float: left;" onchange="document.getElementById('myForm').submit();">
                <option value="New Posts" @if(request()->get('order-by') == 'New Posts') selected="selected" @endif>New Posts</option>
                <option value="Old Posts" @if(request()->get('order-by') == 'Old Posts') selected="selected" @endif>Old Posts</option>
                <option value="Most Commented" @if(request()->get('order-by') == 'Most Commented') selected="selected" @endif>Most Commented</option>
            </select>
            <input type="hidden" name="search" value="{{request()->get('search')}}">
            @if(isset($blogs))
                <h5 style="float: left; margin-left: 10px; margin-top: 20px;"> found {{ $blogs->count() }} Results</h5>
            @endif

            <select name="num-results" class="form-control" style="margin-left: 10px;" onchange="document.getElementById('myForm').submit();">
                <option value="10" @if(request()->get('num-results') == '10') selected="selected" @endif>with 10 per page</option>
                <option value="20" @if(request()->get('num-results') == '20') selected="selected" @endif>with 20 per page</option>
                <option value="50" @if(request()->get('num-results') == '50') selected="selected" @endif>with 50 per page</option>
                <option value="100" @if(request()->get('num-results') == '100') selected="selected" @endif>with 100 per page</option>
            </select>
        </div>

        <button type="submit" class="btn btn-default" id="submit-btn" name="submit-btn" style="display: none;">Submit</button>
    </form>
</div>
<div class="row"></div>