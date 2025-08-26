const ColorPicker = {
    init: () => {
        ColorPicker.action();
    },
    action: () => {
        acf?.addFilter('color_picker_args', (args, field) => {
            if (typeof ModyBase !== 'undefined' && typeof ModyBase.palette !== 'undefined') {
                args.palettes = ModyBase.palette;
                args.disableCustom = true;
            }
            return args;
        });
    }
}

export default ColorPicker;