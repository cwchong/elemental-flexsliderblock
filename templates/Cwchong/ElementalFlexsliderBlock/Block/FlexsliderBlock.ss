<% if $Title && $ShowTitle %>
    <h2 class="animate-element__title">$Title</h2>
<% end_if %>
<div class="animate-element__flexslider flexslider">
    <ul class="slides">
        <% loop $Slides %><li>
            <div class="home-section">
                <div class="pic">$Image</div>
                <div class="text">
                    <p class="lbl">$Tag</p>
                    <h1>$Title</h1>
                    $Caption
                    <% if $ReadMoreLink %><% with $ReadMoreLink %>
                        <a href="{$LinkURL}"{$TargetAttr} class="readmore reddot">
                            {$Title}
                        </a>
                    <% end_with %><% end_if %>
                </div>
            </div>
        </li><% end_loop %>
    </ul>
</div>

<% require javascript('cwchong/elemental-flexsliderblock:client/dist/js/jquery.flexslider.js') %>
<% require javascript('cwchong/elemental-flexsliderblock:client/dist/js/main.js') %>
