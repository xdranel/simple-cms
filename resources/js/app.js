import { HSStaticMethods } from 'preline/non-auto';

function autoInit() {
    HSStaticMethods.autoInit();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', autoInit);
} else {
    autoInit();
}
