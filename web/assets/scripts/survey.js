import { User } from "./user";
import { http } from "./http";
import { nextSlide } from "./utilities";
import { Loading } from "./loading";

export async function survey() {
  openDraggableMobile();

  if (User.instance.value.surveys && User.instance.value.surveys.length > 0) {
    const activeSurvey = User.instance.value.surveys.find(
      (survey) => !survey.completed
    );

    User.instance.set({ ...User.instance.value, activeSurvey });

    if (
      activeSurvey?.groupTextMappings &&
      activeSurvey.groupTextMappings.filter((group) => group.textGroup === null)
        ?.length === 0
    ) {
      document.querySelector(".survey-completed-next").classList.add("show");
    }

    constructQuestions(activeSurvey);

    // Select the node that will be observed for mutations

    // Options for the observer (which mutations to observe)
    const config = {
      attributes: true,
      childList: false,
      attributeOldValue: false,
      attributeFilter: ["class"],
      subtree: false,
    };

    const callback = async (mutationList, observer) => {
      for (const mutation of mutationList) {
        if (!mutation.target.classList.contains("dragged-item")) {
          const groupTextMappings = [
            {
              id: Number(mutation.target.dataset.groupTextMappingsId),
              textGroup: mutation.target.parentNode.dataset.textGroupId
                ? Number(mutation.target.parentNode.dataset.textGroupId)
                : null,
            },
          ];

          const survey = {
            id: mutation.target.dataset.serveyId,
            groupTextMappings,
            isCompleted: false,
          };

          try {
            const response = await http(
              `user/${User.instance.value.email}/survey/${mutation.target.dataset.serveyId}`,
              "PATCH",
              survey
            );

            User.instance.set({
              ...User.instance.value,
              activeSurvey: response.surveys.find(
                (survey) =>
                  survey.id === Number(mutation.target.dataset.serveyId)
              ),
            });

            if (
              User.instance?.value.activeSurvey?.groupTextMappings &&
              User.instance?.value.activeSurvey?.groupTextMappings.filter(
                (group) => group.textGroup === null
              )?.length === 0
            ) {
              document
                .querySelector(".survey-completed-next")
                .classList.add("show");
            } else {
              document
                .querySelector(".survey-completed-next")
                .classList.remove("show");
            }
          } catch (error) {
            console.log(error);
          }
        }
      }
    };

    document.querySelectorAll(".bubble").forEach((dragItem) => {
      const observer = new MutationObserver(callback);
      observer.observe(dragItem, config);
    });
  }

  void completeSurvey();
}

function constructQuestions(activeSurvey) {
  const wrapper = document.querySelector(".texts");
  const ul = document.createElement("ul");
  const dialogWrapper = document.createElement("div");
  ul.classList.add("bubble-boundary", "animations");
  ul.dataset.role = "drag-items";

  if (!activeSurvey || !activeSurvey.groupTextMappings) {
    // Go to new survey page
    console.log("No survey found");
  }

  activeSurvey.groupTextMappings.forEach((groupTextMappings, index) => {
    const { text, author } = groupTextMappings?.text;
    const { textGroup } = groupTextMappings;

    const li = addDraggableItems(
      {
        surveyId: activeSurvey.id,
        text,
        author,
        groupTextMappingsId: groupTextMappings.id,
      },
      index
    );

    if (textGroup) {
      document
        .querySelector(
          `.drag-items-moved-target[data-text-group-id="${textGroup}"]`
        )
        .append(li);
    } else {
      ul.append(li);
    }

    dialogWrapper.append(addDialogs(text, author, index));
  });

  wrapper.append(ul, dialogWrapper);

  setTimeout(() => {
    ul.classList.remove("animations");
  }, 2000);
}

function addDraggableItems(
  { surveyId, text, author, groupTextMappingsId },
  index
) {
  const li = document.createElement("li");
  li.classList.add("drag-texts", "bubble");
  li.dataset.serveyId = surveyId;
  li.dataset.groupTextMappingsId = groupTextMappingsId;

  const button = document.createElement("button");
  button.classList.add("pl-0", "mif-info", "mr-1");

  button.addEventListener("focus", (event) => {
    Metro.dialog.open(`#dialog-${index}`);
  });

  const h6 = document.createElement("h6");
  h6.textContent = author;
  const div = document.createElement("div");

  const p = document.createElement("p");
  p.textContent = `${text.slice(0, 65)}...`;
  div.append(h6, p);

  li.append(button, div);

  return li;
}

function addDialogs(text, author, index) {
  const dialog = document.createElement("div");
  dialog.classList.add("dialog");
  dialog.dataset.role = "dialog";
  dialog.id = `dialog-${index}`;

  const dialogContent = document.createElement("div");
  dialogContent.classList.add("dialog-content");

  const dialogActions = document.createElement("div");
  const dialogTitle = document.createElement("h2");
  dialogTitle.classList.add("text-italic");
  dialogTitle.textContent = author;

  const dialogText = document.createElement("p");
  dialogText.innerHTML = text.replace(new RegExp("\r?\n", "g"), "<br />");
  dialogActions.classList.add("dialog-actions");
  const closeButton = document.createElement("button");

  closeButton.classList.add("button", "primary", "js-dialog-close");
  closeButton.textContent = "Close";
  dialogContent.append(dialogTitle, dialogText);
  dialogActions.append(closeButton);
  dialog.append(dialogContent, dialogActions);

  return dialog;
}

export async function completeSurvey() {
  document
    .querySelector(".complete-survey-btn")
    .addEventListener("click", async () => {
      document.querySelector(".survey-completed-next").classList.remove("show");

      const loading = new Loading();
      console.log(User.instance.value.activeSurvey);
      try {
        await http(
          `user/${User.instance.value.email}/survey/${User.instance.value.activeSurvey.id}`,
          "PATCH",
          { ...User.instance.value.activeSurvey, completed: true }
        );
        nextSlide();
      } catch (error) {
      } finally {
        loading.hide();
      }
    });
}

export function openDraggableMobile() {
  document.querySelectorAll(".open-drag").forEach((openDrag, index) => {
    openDrag.addEventListener("click", () => {
      const allDragItems = document.querySelectorAll(".drag");

      allDragItems.forEach((dragItem, index) => {
        dragItem.classList.remove("show");
        document
          .querySelectorAll(".open-drag")
          [index].classList.remove("selected");
      });

      openDrag.classList.add("selected");
      document.querySelectorAll(".drag")[index].classList.toggle("show");
    });
  });
}
