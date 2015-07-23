 function formatSlug (name) {
		name = name.toLowerCase();
        name = name.replace(/[^a-zA-Z0-9]+/g,'-');

        return name;
	}