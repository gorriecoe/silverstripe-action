<a href="{$LinkURL}"{$ClassAttr}{$TargetAttr}>
    <% if Image %>
        <% with Image %>
            <img src="$Fill(320,200).Link" alt="{$Title}" aria-hidden="true" />
        <% end_with %>
    <% end_if %>
    <% if Title %>
        <h2 class="title">
            {$Title}
        </h2>
    <% end_if %>
    <% if Summary %>
        <div class="summary">
            <p>
                {$Summary}
            </p>
        </div>
    <% end_if %>
    <% if Label %>
        <span class="button">
            {$Label}
        </span>
    <% end_if %>
</a>
