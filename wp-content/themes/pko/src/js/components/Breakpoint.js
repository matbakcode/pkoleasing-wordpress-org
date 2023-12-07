class Breakpoint {
    constructor() {
        this.sizes = {
            sm: 576,
            md: 768,
            lg: 1024,
            xl: 1280,
        }
    }
}

const breakpoint = new Breakpoint();

export default breakpoint;