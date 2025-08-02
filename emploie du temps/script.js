document.addEventListener("DOMContentLoaded", function () {
  const jourSelect = document.getElementById("jour");
  const moisSelect = document.getElementById("mois");
  const planningList = document.getElementById("planning-list");
  const form = document.getElementById("revision-form");

  // Remplir le sélecteur des jours
  for (let i = 1; i <= 31; i++) {
    const option = document.createElement("option");
    option.value = i;
    option.textContent = i;
    jourSelect.appendChild(option);
  }

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    // Récupérer les valeurs sélectionnées
    const mois = moisSelect.value;
    const jour = jourSelect.value;
    const matiere = document.getElementById("matiere").value.trim();

    if (matiere === "") {
      alert("Veuillez entrer une matière.");
      return;
    }

    // Créer un nouvel élément de planning
    const listItem = document.createElement("li");
    listItem.textContent = `${jour} ${mois} - ${matiere}`;

    // Ajouter l'élément au planning
    planningList.appendChild(listItem);

    // Réinitialiser le formulaire
    form.reset();
  });
});
