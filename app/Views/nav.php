<div class="navbar bg-base-300 md:shadow-sm md:bg-black/20 md:backdrop-blur-md">
    <div class="flex-1">
        <a class="btn btn-ghost text-xl">
            <img class="h-6 w-auto" src="<?=base_url('gfx/logo.svg')?>" alt="CoreWatch Logo">
        </a>
    </div>
    <div class="hidden lg:flex lg:gap-4 px-4">

        <fieldset class="fieldset">
            <label class="label">
                <input type="checkbox" class="toggle toggle-sm" data-toggle="fullScreen" />
                Full Screen
            </label>
        </fieldset>

        <fieldset class="fieldset">
            <label class="label">
                <input type="checkbox" class="toggle toggle-sm" data-toggle="refresh" />
                Auto Refresh
            </label>
        </fieldset>
    </div>
</div>