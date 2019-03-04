<div class="col-sm-12" style="border-bottom: 1px solid #ccc; border-bottom-left-radius: 0; border-bottom-right-radius: 0; margin-bottom: 20px;">
    <form class="form-inline" action="{{ request()->getRequestUri() }}" method="GET" name="myForm" id="myForm">
        <div style="display: inline-block;">
            <div class="form-group">
                <label for="order-by">Order By</label>
                <select id="order-by" name="order-by" class="form-control" onchange="document.getElementById('myForm').submit();" style="padding-top: 0px; padding-bottom: 0px; height: 25px;">
                    <option value="New Posts" @if(request()->get('order-by') == 'New Posts') selected="selected" @endif>New Posts</option>
                    <option value="Old Posts" @if(request()->get('order-by') == 'Old Posts') selected="selected" @endif>Old Posts</option>
                    <option value="Most Commented" @if(request()->get('order-by') == 'Most Commented') selected="selected" @endif>Most Commented</option>
                </select>
            </div>
            <input type="hidden" name="search" value="{{request()->get('search')}}">
            <div class="form-group" style="top: -1px; position: relative;">
                <select name="num-results" class="form-control" onchange="document.getElementById('myForm').submit();" style="padding-top: 0px; padding-bottom: 0px; height: 25px;">
                    <option value="10" @if(request()->get('num-results') == '10') selected="selected" @endif>10 posts per page</option>
                    <option value="20" @if(request()->get('num-results') == '20') selected="selected" @endif>20 posts per page</option>
                    <option value="50" @if(request()->get('num-results') == '50') selected="selected" @endif>50 posts per page</option>
                    <option value="100" @if(request()->get('num-results') == '100') selected="selected" @endif>100 posts per page</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-default" id="submit-btn" name="submit-btn" style="display: none;">Submit</button>
    </form>
    @if(isset($blogs))
        @if(count($blogs)>0)
            <h5 style="font-size: 120%; margin-top: 20px;">Found <span style="font-size: 150%">{{ $blogs->total() }}</span> {{ $blogs->total() > 1 ? 'results' : 'result' }}@if(request()->get('search')) for "<strong>{{ request()->get('search') }}</strong>"@endif. Showing results from {{ $blogs->firstItem() }} to {{ $blogs->lastItem() }}</h5>
        @elseif(request()->get('search')!==null)
            <h5 style="font-size: 120%; margin-top: 20px;">No results found for: "{{ request()->get('search') }}"</h5>
        @elseif(request()->get('search')===null && count($blogs)===0)
            <h5 style="font-size: 120%; margin-top: 20px;">This category is empty</h5>
        @endif
    @endif
</div>
<div class="row"></div>