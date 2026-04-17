import path from 'node:path';

export default {
    '**/*.php': (filenames) => {
        const relativeFiles = filenames
            .map((file) => path.relative(process.cwd(), file))
            .join(' ');

        return `./vendor/bin/sail bin pint ${relativeFiles}`;
    },
    '**/*.{blade.php,js,css,json,md}': ['npx prettier --write'],
};
